<?php

namespace App\Http\Controllers\Operator;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('operator.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $recaptcha = $request->input('g-recaptcha-response');

        // Validasi bahwa ReCAPTCHA ada
        if (is_null($recaptcha)) {
            return redirect()->back()->withErrors(['message' => 'Please complete the recaptcha to proceed.']);
        }

        // Kirim request ke Google ReCAPTCHA API
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret'),
            'response' => $recaptcha,
            'remoteip' => $request->ip(),
        ]);

        // Decode response dari Google
        $result = json_decode($response->body());

        // Cek apakah request sukses dan ReCAPTCHA berhasil diverifikasi
        if ($response->successful() && $result->success) {
            // Cek kredensial untuk admin

            if (Auth::guard('operator')->attempt($credentials)) {
                return redirect()->intended('/operator/dashboard');
            }

            // Jika kredensial salah
            return redirect()->back()->withErrors(['email' => 'Email or password is incorrect']);
        } else {
            // Jika ReCAPTCHA gagal
            return redirect()->back()->withErrors(['message' => 'ReCAPTCHA verification failed. Please try again.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('operator.login')->with('message', 'You have been logged out successfully.');
    }
}
