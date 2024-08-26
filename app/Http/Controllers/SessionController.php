<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index(): View {
        return view('auth.login');
    }
    public function create() {
        dd("login");
    }
}
