<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge(['phone' => User::normalizePhone($request->phone)]);

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'phone'    => ['required', 'regex:/^08\d{8,12}$/',
                           Rule::unique('users', 'phone')->whereNull('deleted_at')],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'phone.regex'  => 'Format nomor HP tidak valid (contoh 081234567890).',
            'phone.unique' => 'Nomor HP sudah terdaftar.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'password' => $request->password,
        ]);

        $user->tenant()->create(['phone' => $user->phone]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}