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
            ->select('cntrl_no', 'group_no', 'year____', 'month___',
                    'part____', 'seqn_num', 'strt_dte', 'last_dte',
                    'remarks_', 'w2_year_', 'status__', 'appl_prd')
            ->where('primekey', $request->primekey)
            ->get();
        
        return response()->json($directories, 200);
    }
}
