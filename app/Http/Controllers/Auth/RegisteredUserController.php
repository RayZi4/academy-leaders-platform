<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'in:student,mentor,customer'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Определяем, нуждается ли пользователь в подтверждении
        $needsApproval = in_array($request->role, ['mentor', 'customer']);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'is_approved' => !$needsApproval, // студенты сразу одобрены
        ]);

        event(new Registered($user));

        if (!$needsApproval) {
            // Студент – сразу логиним и пускаем в систему
            Auth::login($user);
            return redirect()->route('catalog');
        } else {
            // Наставник или заказчик – показываем страницу ожидания подтверждения
            Auth::login($user); // Логиним, но middleware проверит is_approved и заблокирует доступ
            return redirect()->route('awaiting-approval');
        }
    }
}
