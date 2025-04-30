<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showForm()
    {
        return view('auth_form');
    }

    public function register(Request $request)
    {
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');

        if (!$username || !$email || !$password) {
            return redirect()->route('auth.form')->with('error', 'Заполните все поля!');
        }

        $userByEmail = User::where('email', $email)->first();
        $userByUsername = User::where('username', $username)->first();

        if ($userByEmail || $userByUsername) {
            return redirect()->route('auth.form')->with('error', 'Такой пользователь уже существует');
        }

        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        session(['username' => $user->username]);

        return redirect()->route('home')->with('success', 'Вы успешно зарегистрировались!');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (!$email || !$password) {
            return redirect()->route('auth.form')->with('error', 'Email или пароль введены неверно');
        }

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return redirect()->route('auth.form')->with('error', 'Неверный email или пароль');
        }

        session(['username' => $user->username]);

        return redirect()->route('home')->with('success', 'Вы успешно авторизовались!');
    }

    public function logout()
    {
        session()->forget('username');

        return redirect()->route('home')->with('success', 'Вы успешно вышли из системы.');
    }
}
