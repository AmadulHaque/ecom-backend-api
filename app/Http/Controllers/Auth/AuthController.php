<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Traits\UserCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use UserCheck;

    public function login(Request $request)
    {
        return view('Admin::auth.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'phone_mail' => 'required',
            'password' => 'required|min:6',
        ]);

        $user = $this->checkUserByEmailOrPhone($request->phone_mail);

        if ($user && ($user->role == UserRole::SHOP_SUPER_ADMIN or $user->role == UserRole::SHOP_ADMIN) && $this->passwordCheck($user, $request->password)) {
            Auth::guard('admin')->login($user);

            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->with(['error' => 'Invalid credentials']);
    }

    public function passwordCheck($user, $password)
    {
        return Hash::check($password, $user->password);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }
}
