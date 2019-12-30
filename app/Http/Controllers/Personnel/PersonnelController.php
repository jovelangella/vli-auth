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

    public function createDtrFolder(Request $request)
    {
        foreach ($request->dtr_date as $dtr_date) {

            $max = $this->getMaximumID($primekey);

            DB::table('l_dtr_hdr_')
            ->insert([
                'primekey' => $primekey,
                'cntrl_no' => $max,
                'dtr_date' => $dtr_date,
                'day_type' => '01',
                'ttl_empl' => 0,
                'ttl_err_' => 0,
                'creat_dt' => Carbon::now()->format('Y-m-d'),
                'creat_by' => '0000',
                'compweek' => 'F'
            ]);
        }

        DB::table('q_payr_dir')
        ->where('primekey', $primekey)
        ->where('cntrl_no', $cntrl_no)
        ->update([
            'dtr_fldr' => 'T'
        ]);
    }
    
    public function getMaximumID($primekey)
    {
        $max = DB::table('l_dtr_hdr_')
        ->where('primekey', $primekey)
        ->max('cntrl_no');

        if (!is_null(rtrim($max))){
            $max = rtrim($max);
            $max ++;
        } else {
            $max = 0;
            $max ++;
        }

        return $max;
    }
}
