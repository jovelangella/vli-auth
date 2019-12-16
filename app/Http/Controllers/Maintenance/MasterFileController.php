<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class MasterFileController extends Controller
{
    public function index(Request $request)
    {
        $s_empl_mst = DB::table('s_empl_mst')
        ->where('s_empl_mst.primekey', $request->primekey)
        ->where('l_emplpers.primekey', $request->primekey)
        ->where('l_emplgenr.primekey', $request->primekey)
        ->where('l_emplgovn.primekey', $request->primekey)
        ->join('l_emplpers', 'l_emplpers.empl_cde', '=', 's_empl_mst.empl_cde')
        ->join('l_emplgenr', 'l_emplgenr.empl_cde', '=', 's_empl_mst.empl_cde')
        ->join('l_emplgovn', 'l_emplgovn.empl_cde', '=', 's_empl_mst.empl_cde')
        ->select('s_empl_mst.*', 'l_emplpers.*', 'l_emplgenr.*', 'l_emplgovn.*')
        ->get();

        return response()->json($s_empl_mst, 200);
    }
}
