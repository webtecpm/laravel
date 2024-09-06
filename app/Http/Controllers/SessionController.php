<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create(): View {
        return view('auth.login');
    }

    public function store() {
        // validate
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // attempt to login the user
        if(! Auth::attempt($attributes) ) {
            throw ValidationException::withMessages([
                'email' => "Sorry, those credentials are not good.",
            ]);
        }

        // regenerate the session token
        request()->session()->regenerate();

        // redirect
        return redirect('/jobs');

        // dd(request()->all());
    }

    public function destroy() {
        Auth::logout();
        return redirect('/');
    }
}
