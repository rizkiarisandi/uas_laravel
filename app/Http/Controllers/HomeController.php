<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kriteria;
use App\Models\Alternatif;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();
        $kriteriaCount = Kriteria::count(); // Count the number of kriteria
        $alternatifCount = Alternatif::count();
        $widget = [
            'users' => $users,
            'kriteriaCount' => $kriteriaCount,
            'alternatifCount'=>$alternatifCount,
        ];

        return view('home', compact('widget'));
    }
}
