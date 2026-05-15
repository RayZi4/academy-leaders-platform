<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Показать профиль текущего пользователя
    public function show()
    {
        $user = auth()->user();
        $projects = collect(); // пустая коллекция по умолчанию

        if ($user->isStudent()) {
            $projects = $user->studentProjects()->with('project')->get();
        } elseif ($user->isCustomer()) {
            $projects = $user->customerProjects()->with('mentor')->get();
        }

        return view('profile.show', compact('user', 'projects'));
    }

    // Показать профиль другого пользователя (только студента)
    public function showStudent(User $user)
    {
        if ($user->role !== 'student') {
            abort(404, 'Пользователь не является студентом.');
        }
        $projects = $user->studentProjects()->with('project')->get();
        return view('profile.show', compact('user', 'projects'));
    }

    // Форма редактирования профиля
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    // Обновление профиля
    public function update(Request $request)
    {
        $user = auth()->user();
        $rules = [
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Имя можно менять только не-организациям
        if (!$user->isCustomer()) {
            $rules['name'] = 'required|string|max:255';
        }

        $request->validate($rules);

        if (!$user->isCustomer() && $request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('bio')) {
            $user->bio = $request->bio;
        }

        if ($request->hasFile('avatar')) {
            // Удаляем старый аватар, если есть
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Профиль обновлён.');
    }
}
