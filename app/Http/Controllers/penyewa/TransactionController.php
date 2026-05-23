<?php

namespace App\Http\Controllers\penyewa;

use App\Http\Controllers\Controller;
use App\Models\AdditionalService;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Cek & update status pembayaran pending via Midtrans API.
     * Dipanggil setiap kali user membuka tab history.
     */
    public function checkPaymentStatus()
    {
        \Midtrans\Config::$serverKey    = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);

        $bookings = Booking::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->get();

        foreach ($bookings as $booking) {
            try {
                $status            = \Midtrans\Transaction::status($booking->id);
                $transactionStatus = $status->transaction_status ?? '';
                $fraudStatus       = $status->fraud_status ?? null;

                if ($transactionStatus === 'capture') {
                    if ($fraudStatus === 'challenge') {
                        $booking->update(['status' => 'pending']);
                    } else {
                        $booking->update(['status' => 'paid']);
                        optional($booking->room)->update(['status' => 'occupied']);
                    }
                } elseif ($transactionStatus === 'settlement') {
                    $booking->update(['status' => 'paid']);
                    optional($booking->room)->update(['status' => 'occupied']);
                } elseif ($transactionStatus === 'expire') {
                    $booking->update(['status' => 'expired']);
                } elseif (in_array($transactionStatus, ['cancel', 'deny'])) {
                    $booking->update(['status' => 'canceled']);
                }
            } catch (\Exception $e) {
                continue;
            }
        }
    }

    public function webhook(Request $request)
    {
        \Midtrans\Config::$serverKey    = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);

        try {
            $notification  = new \Midtrans\Notification();
            $orderId       = $notification->order_id;
            $status        = $notification->transaction_status;
            $fraudStatus   = $notification->fraud_status ?? null;

            $booking = Booking::find($orderId);
            if (!$booking) {
                return response()->json(['message' => 'Booking not found'], 404);
            }

            if ($status === 'capture') {
                $booking->status = $fraudStatus === 'challenge' ? 'pending' : 'paid';
                if ($booking->status === 'paid') {
                    optional($booking->room)->update(['status' => 'occupied']);
                }
            } elseif ($status === 'settlement') {
                $booking->status = 'paid';
                optional($booking->room)->update(['status' => 'occupied']);
            } elseif ($status === 'expire') {
                $booking->status = 'expired';
            } elseif (in_array($status, ['cancel', 'deny'])) {
                $booking->status = 'canceled';
            } elseif ($status === 'pending') {
                $booking->status = 'pending';
            }

            $booking->save();

            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Halaman konfirmasi pesanan (step 2).
     */
    public function bookingConfirmation(Request $request)
    {
        $request->validate([
            'room_id'    => 'required|exists:rooms,id',
            'check_in'   => 'required|date|after_or_equal:today',
            'check_out'  => 'required|date|after:check_in',
            'services'   => 'nullable|array',
            'services.*' => 'exists:additional_services,id',
        ]);

        $room     = Room::with('roomType')->findOrFail($request->room_id);
        $checkIn  = \Carbon\Carbon::parse($request->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);
        $days     = max(1, $checkIn->diffInDays($checkOut));

        $daily   = $room->roomType->base_price_daily;
        $weekly  = $room->roomType->base_price_weekly;
        $monthly = $room->roomType->base_price_monthly;

        if ($days >= 30) {
            $roomPrice = (floor($days / 30) * $monthly) + (($days % 30) * $daily);
        } elseif ($days >= 7) {
            $roomPrice = (floor($days / 7) * $weekly) + (($days % 7) * $daily);
        } else {
            $roomPrice = $days * $daily;
        }

        $detailServices = [];
        $totalService   = 0;

        if (!empty($request->services)) {
            $services = AdditionalService::whereIn('id', $request->services)->get();
            foreach ($services as $s) {
                $isWeekly     = str_contains(strtolower($s->duration_type), 'minggu');
                $qty          = $isWeekly ? (int) floor($days / 7) : $days;
                $unit         = $isWeekly ? 'Minggu' : 'Hari';
                $cost         = $s->service_price * $qty;
                $totalService += $cost;

                $detailServices[] = [
                    'id'         => $s->id,
                    'name'       => $s->service_name,
                    'price_unit' => $s->service_price,
                    'qty'        => $qty,
                    'unit'       => $unit,
                    'cost'       => $cost,
                ];
            }
        }

        $grandTotal = $roomPrice + $totalService;
        $title      = 'Konfirmasi Pesanan - Griya Asri Kos';

        return view('penyewa.transactions.booking_confirmation', compact(
            'room',
            'checkIn',
            'checkOut',
            'days',
            'roomPrice',
            'detailServices',
            'grandTotal',
            'title'
        ));
    }

    /**
     * Halaman pembayaran Midtrans (step 3).
     */
    public function payment(Request $request)
    {
        $request->validate([
            'room_id'         => 'required|exists:rooms,id',
            'check_in'        => 'required|date',
            'check_out'       => 'required|date|after:check_in',
            'grand_total'     => 'required|integer|min:1',
            'service_details' => 'nullable|string',
        ]);

        $room           = Room::with('roomType')->findOrFail($request->room_id);
        $checkIn        = \Carbon\Carbon::parse($request->check_in);
        $checkOut       = \Carbon\Carbon::parse($request->check_out);
        $days           = max(1, $checkIn->diffInDays($checkOut));
        $grandTotal     = (int) $request->grand_total;
        $serviceDetails = json_decode($request->service_details ?? '[]', true);
        $deadline       = now()->addDay()->translatedFormat('d M Y, H:i') . ' WIB';
        $title          = 'Pembayaran - Griya Asri Kos';

        return view('penyewa.transactions.payment', compact(
            'room',
            'checkIn',
            'checkOut',
            'days',
            'grandTotal',
            'serviceDetails',
            'deadline',
            'title'
        ));
    }

    /**
     * Endpoint AJAX: buat booking + ambil Snap Token Midtrans.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'room_id'         => 'required|exists:rooms,id',
            'check_in'        => 'required|date',
            'check_out'       => 'required|date|after:check_in',
            'total_price'     => 'required|integer|min:1',
            'service_details' => 'nullable|array',
        ]);

        $user    = auth()->user();
        $orderId = 'KOS-' . time();
        $room    = Room::findOrFail($request->room_id);

        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'id'          => $orderId,
                'user_id'     => $user->id,
                'room_id'     => $request->room_id,
                'check_in'    => $request->check_in,
                'check_out'   => $request->check_out,
                'total_price' => $request->total_price,
                'status'      => 'pending',
            ]);

            if (!empty($request->service_details)) {
                foreach ($request->service_details as $s) {
                    $service = AdditionalService::where('service_name', $s['name'])->first();
                    if ($service) {
                        $booking->additionalServices()->attach($service->id, [
                            'quantity'          => $s['qty'],
                            'price_at_purchase' => (int) ($s['cost'] / max(1, $s['qty'])),
                            'created_at'        => now(),
                            'updated_at'        => now(),
                        ]);
                    }
                }
            }

            \Midtrans\Config::$serverKey    = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
            \Midtrans\Config::$isSanitized  = true;
            \Midtrans\Config::$is3ds        = true;

            $params = [
                'transaction_details' => [
                    'order_id'     => $orderId,
                    'gross_amount' => $request->total_price,
                ],
                'item_details' => [
                    [
                        'id'       => $request->room_id,
                        'price'    => $request->total_price,
                        'quantity' => 1,
                        'name'     => 'Kamar ' . $room->room_number,
                    ]
                ],
                'customer_details' => [
                    'first_name' => $user->nickname,
                    'email'      => $user->email,
                    'phone'      => $user->phone ?? '',
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $booking->update(['payment_token' => $snapToken]);

            DB::commit();
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function receipt($id)
    {
        $booking = Booking::with(['room.roomType', 'additionalServices'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'paid')
            ->firstOrFail();

        $checkIn  = \Carbon\Carbon::parse($booking->check_in);
        $checkOut = \Carbon\Carbon::parse($booking->check_out);
        $days     = max(1, $checkIn->diffInDays($checkOut));

        $totalServiceCost = 0;
        $serviceDetails   = [];
        foreach ($booking->additionalServices as $s) {
            $isWeekly = str_contains(strtolower($s->duration_type), 'minggu');
            $qty      = $isWeekly ? (int) floor($days / 7) : $days;
            $unit     = $isWeekly ? 'Minggu' : 'Hari';
            $cost     = $s->service_price * $qty;
            $totalServiceCost += $cost;
            $serviceDetails[] = [
                'name'       => $s->service_name,
                'qty'        => $qty,
                'unit'       => $unit,
                'price_unit' => $s->service_price,
                'cost'       => $cost,
            ];
        }

        $roomPrice  = $booking->total_price - $totalServiceCost;
        $title      = 'Receipt #' . $booking->id;

        $paymentMethod = 'Midtrans Payment';
        $paymentTime   = $booking->updated_at;
        try {
            \Midtrans\Config::$serverKey    = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
            $status        = \Midtrans\Transaction::status($booking->id);
            $paymentMethod = strtoupper(str_replace('_', ' ', $status->payment_type ?? 'Midtrans Payment'));
            $paymentTime   = $status->transaction_time ?? $booking->updated_at;
        } catch (\Exception $e) {
        }

        return view('penyewa.transactions.receipt', compact(
            'booking',
            'checkIn',
            'checkOut',
            'days',
            'roomPrice',
            'serviceDetails',
            'paymentMethod',
            'paymentTime',
            'title'
        ));
    }
}
