<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UtmController extends Controller
{
    public function index(){

        $utm = DB::table('tbl_myitr_utm')->orderBy('id', 'desc')->get();
        return view('utm.index', compact('utm'));

    }
}
