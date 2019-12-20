<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class PersonnelController extends Controller
{
    public function directories(Request $request)
    {
        $directories = DB::table('q_payr_dir')
            ->where('q_payr_dir.primekey', $request->primekey)
            ->where('q_paygroup.primekey', $request->primekey)
            ->join('q_paygroup', 'q_paygroup.group_no', '=', 'q_payr_dir.group_no')
            ->select('q_payr_dir.cntrl_no', 'q_paygroup.descript', 'q_payr_dir.year____', 'q_payr_dir.month___',
                    'q_payr_dir.part____', 'q_payr_dir.seqn_num', 'q_payr_dir.strt_dte', 'q_payr_dir.last_dte',
                    'q_payr_dir.remarks_', 'q_payr_dir.w2_year_', 'q_payr_dir.status__', 'q_payr_dir.appl_prd')
            ->get();
        
        return response()->json($directories, 200);
    }
}
