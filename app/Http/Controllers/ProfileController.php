<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $username = session('username');
        
        if (!$username) {
            return redirect('/login')->with('error', 'Вы должны быть авторизованы для просмотра профиля.');
        }

        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect('/login')->with('error', 'Пользователь не найден.');
        }

        return view('profile', ['user' => $user]);
    }


    public function uploadAvatar(Request $request)
    {
        $username = session('username');
    
        if (!$username) {
            return redirect('/login')->with('error', 'Вы должны быть авторизованы для загрузки аватарки.');
        }
    
        $user = User::where('username', $username)->first();
    
        if (!$user) {
            return redirect('/login')->with('error', 'Пользователь не найден.');
        }
    
        if (!$request->hasFile('avatar')) {
            return "Файл не выбран.";
        }
    
        $avatar = $request->file('avatar');
        $avatarName = time() . '_' . $avatar->getClientOriginalName();
        $avatar->storeAs('public/avatars', $avatarName);
        $user->avatar = 'storage/avatars/' . $avatarName;
        $user->save();
    
        return "Аватарка успешно загружена.";
    }

    public function editProfile(Request $request)
    {
        $username = session('username');
        
        if (!$username) {
            return redirect('/login')->with('error', 'Вы должны быть авторизованы для редактирования профиля.');
        }
        
        $user = User::where('username', $username)->first();
        
        if (!$user) {
            return redirect('/login')->with('error', 'Пользователь не найден.');
        }
        
        $newUsername = $request->query('username');
        $newEmail = $request->query('email');
        $newPassword = $request->query('password');
        
        if (empty($newUsername) || empty($newEmail)) {
            return redirect('/profile')->with('error', 'Имя пользователя и email обязательны.');
        }
        
        // Проверка уникальности имени пользователя
        $existingUser = User::where('username', $newUsername)->where('id', '!=', $user->id)->first();
        if ($existingUser) {
            return redirect('/profile')->with('error', 'Имя пользователя уже занято.');
        }
        
        // Проверка уникальности email
        $existingEmail = User::where('email', $newEmail)->where('id', '!=', $user->id)->first();
        if ($existingEmail) {
            return redirect('/profile')->with('error', 'Email уже занят.');
        }
        
        // Обновление данных пользователя
        $user->username = $newUsername;
        $user->email = $newEmail;
        
        if (!empty($newPassword)) {
            $user->password = Hash::make($newPassword);
        }
        
        $user->save();
        
        // Обновляем имя артиста, если оно связано с этим пользователем
        if ($user->artist) {
            $user->artist->name = $newUsername;
            $user->artist->save();
        }
        
        // Обновляем имя пользователя в сессии
        session(['username' => $newUsername]);
        
        return redirect('/profile')->with('success', 'Профиль успешно обновлен.');
    }
    
    public function deleteProfile()
    {
        $username = session('username');
    
        if (!$username) {
            return redirect('/login')->with('error', 'Вы должны быть авторизованы для удаления аккаунта.');
        }
    
        $user = User::where('username', $username)->first();
    
        if (!$user) {
            return redirect('/login')->with('error', 'Пользователь не найден.');
        }
    
        $user->delete();
    
        session()->forget('username');
    
        return redirect('/')->with('success', 'Аккаунт успешно удален.');
    }
    
}