<?php

namespace App\Http\Controllers;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if(Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if(Auth::attempt($validated)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login realizado com sucesso!');
        }

        return back()->withErrors([
            'email' => 'Email ou senha inválidos.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if(Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => $this->strongPasswordRules(),
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'country' => $validated['country'] ?? null,
            'role' => 'user',
            'is_active' => true,
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Conta criada com sucesso!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Logout realizado com sucesso!');
    }

    public function profile()
    {
        return view('auth.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => [
                'nullable',
                'different:current_password',
                ...$this->strongPasswordRules(false),
            ],
        ]);

        if($request->filled('new_password')) {
            $user->password = bcrypt($request->new_password);
        }

        $user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? $user->phone,
            'country' => $validated['country'] ?? $user->country,
        ]);

        return back()->with('success', 'Perfil atualizado com sucesso!');
    }

    private function strongPasswordRules(bool $required = true): array
    {
        $rules = [
            'string',
            'min:6',
            'confirmed',
            function (string $attribute, mixed $value, Closure $fail): void {
                $passwordRaw = (string) $value;
                $password = strtolower($passwordRaw);

                if (!preg_match('/[A-Z]/', $passwordRaw)) {
                    $fail('A senha deve conter pelo menos 1 letra maiúscula.');
                    return;
                }

                if (!preg_match('/\d/', $passwordRaw)) {
                    $fail('A senha deve conter pelo menos 1 número.');
                    return;
                }

                if (!preg_match('/[^a-zA-Z0-9]/', $passwordRaw)) {
                    $fail('A senha deve conter pelo menos 1 caractere especial.');
                    return;
                }

                $weakWords = ['123456', '12345678', 'qwerty', 'password', 'admin', 'senha'];
                foreach ($weakWords as $word) {
                    if ($password === $word) {
                        $fail('A senha contém um padrão fraco ou previsível.');
                        return;
                    }
                }

                if (preg_match('/^(.)\\1+$/', $password)) {
                    $fail('A senha não pode ser composta por um único caractere repetido.');
                    return;
                }

                if (preg_match('/^\d+$/', $password)) {
                    $fail('A senha não pode conter apenas números.');
                }
            },
        ];

        if ($required) {
            array_unshift($rules, 'required');
        }

        return $rules;
    }
}
