<?php

namespace App\Http\Controllers\User;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('user.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $recaptcha = $request->input('g-recaptcha-response');

        // Validasi bahwa ReCAPTCHA ada
        // if (is_null($recaptcha)) {
        //     return redirect()->back()->withErrors(['message' => 'Please complete the recaptcha to proceed.']);
        // }

        // // Kirim request ke Google ReCAPTCHA API
        // $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        //     'secret' => config('services.recaptcha.secret'),
        //     'response' => $recaptcha,
        //     'remoteip' => $request->ip(),
        // ]);

        // Decode response dari Google
        $result = json_decode($response->body());

        // Cek apakah request sukses dan ReCAPTCHA berhasil diverifikasi
        // if ($response->successful() && $result->success) {
            // Cek kredensial untuk admin
            if (Auth::guard('web')->attempt($credentials)) {
                return redirect()->intended('/users/dashboard');
            }

            // Jika kredensial salah
            return redirect()->back()->withErrors(['email' => 'Email or password is incorrect']);
        // } else {
        //     // Jika ReCAPTCHA gagal
        //     return redirect()->back()->withErrors(['message' => 'ReCAPTCHA verification failed. Please try again.']);
        // }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('message', 'You have been logged out successfully.');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showLinkRequestForm()
    {
        return view('user.auth.email');
    }

    public function showRegistrationForm()
    {
        return view('user.auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'tempat_lahir' => $request->input('tempat_lahir'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran Berhasil! Silahkan log in.');
    }
}
