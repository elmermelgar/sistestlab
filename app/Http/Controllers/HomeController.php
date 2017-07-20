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

    /**
     * @param Request $request
     */
    public function test(Request $request)
    {
        dump($request->all());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function menu(Request $request)
    {
        session(['minimize' => $request->minimize === 'true' ? true : false]);
        return response(['ok' => $request->minimize], 200);
    }

}
