<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create() : View {
        return view('auth.register');
    }

    public function store() : RedirectResponse {
        dd(request()->all());
        return redirect('/');
    }

}
