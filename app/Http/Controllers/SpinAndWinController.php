<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class SpinAndWinController extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('reward_entries')
            ->select('email', 'reward', 'created_at', 'is_eligible')
            ->orderBy('id', 'desc')
            ->get();
        return view('spin_win.index', ['spin_data' => $data]);
    }
}
