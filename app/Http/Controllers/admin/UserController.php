<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = User::where('role', 'penyewa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name_ktp', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->get();

        return view('admin.list-user', compact('users', 'search'));
    }
}
