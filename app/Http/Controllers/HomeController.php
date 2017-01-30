<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jleon\LaravelPnotify\Notify;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    /**
     * Show the Index Page
     * @Get("notificaciones")
     * @return \Illuminate\Http\Response
     */
    public function getNotificaciones()
    {
        Notify::success('Usted esta siendo notificado', 'Exito!!');
        return view('notificaciones');
    }

    /**
     * Show the Index Page
     * @Get("advanced")
     * @return \Illuminate\Http\Response
     */
    public function input()
    {
        return view('advanced');
    }
}
