<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Helper extends Controller
{
    public function employmentStatus(Request $request)
    {
        $employmentStatus = DB::table('l_mplystat')
            ->select('cntrl_no', 'descript')
            ->where('disabled', 'F')
            ->get();

        return response()->json($employmentStatus, 200);
    }

    public function positions(Request $request)
    {
        $positions = DB::table('l_empl_pos')
            ->where('primekey', $request->primekey)
            ->select('pos_code', 'descript')
            ->orderBy('descript')
            ->get();

        return response()->json($positions, 200);
    }
}
