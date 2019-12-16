<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Helper extends Controller
{
    public function philhealth(Request $request)
    {
        $philhealth = DB::table('l_emplgovn')
            ->select('philhlth')
            ->where('primekey', $request->primekey)
            ->get();
        
        return response()->json($philhealth, 200);
    }

    public function pagibig(Request $request)
    {
        $pagibig = DB::table('l_emplgovn')
            ->select('pag_ibig')
            ->where('primekey', $request->primekey)
            ->get();
        
        return response()->json($pagibig, 200);
    }

    public function sss(Request $request)
    {
        $sss = DB::table('l_emplgovn')
            ->select('sss_numb')
            ->where('primekey', $request->primekey)
            ->get();
        
        return response()->json($sss, 200);
    }

    public function tin(Request $request)
    {
        $tin = DB::table('l_emplgovn')
            ->select('tax_numb')
            ->where('primekey', $request->primekey)
            ->where('empl_cde', $request->empl_cde)
            ->get();
        
        return response()->json($tin, 200);
    }
    
    public function section(Request $request)
    {
        $section = DB::table('l_grp_lvl3')
            ->select('pos_code', 'descript')
            ->where('primekey', $request->primekey)
            ->where('disabled', 'F')
            ->get();
        
        return response()->json($section, 200);
    }
    
    public function department(Request $request)
    {
        $deparment = DB::table('l_grp_lvl2')
            ->select('pos_code', 'descript')
            ->where('primekey', $request->primekey)
            ->where('disabled', 'F')
            ->orderBy('descript')
            ->get();
        
        return response()->json($deparment, 200);
    }
    
    public function division(Request $request)
    {
        $division = DB::table('l_grp_lvl1')
            ->select('pos_code', 'descript')
            ->where('primekey', $request->primekey)
            ->where('disabled', 'F')
            ->orderBy('descript')
            ->get();
        
        return response()->json($division, 200);
    }
    public function workArea(Request $request)
    {
        $workArea = DB::table('l_workarea')
            ->select('cntrl_no', 'descript')
            ->where('primekey', $request->primekey)
            ->where('disabled', 'F')
            ->orderBy('descript')
            ->get();
        
        return response()->json($workArea, 200);
    }

    public function workStat(Request $request)
    {
        $workStat = DB::table('l_workstat')
            ->select('cntrl_no', 'descript')
            ->where('primekey', $request->primekey)
            ->where('disabled', 'F')
            ->orderBy('descript')
            ->get();
        
        return response()->json($workStat, 200);
    }
    public function employmentStatus(Request $request)
    {
        $employmentStatus = DB::table('l_mplystat')
            ->select('cntrl_no', 'descript')
            ->where('disabled', 'F')
            ->orderBy('descript')
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
