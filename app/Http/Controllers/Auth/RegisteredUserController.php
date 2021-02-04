<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'role_id' => $request->role_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        if ($request->role_id == '2') {
            Student::create([
                'nis' => $request->nis,
                'user_id' => $user->id,
                'name' => $request->name
            ]);
        } else {
            Teacher::create([
                'nip' => $request->nip,
                'user_id' => $user->id,
                'name' => $request->name
            ]);
        }
       

        Auth::login($user);

        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);
    }
}
