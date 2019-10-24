<?php

namespace App\Http\Controllers;

// use App\Permission;
// use App\User;

use Illuminate\Http\Request;
use App\Models\{Querymodel};
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
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
        $data['config'] = DB::table('config')->first();
        return view('settings', $data);
    }
}
