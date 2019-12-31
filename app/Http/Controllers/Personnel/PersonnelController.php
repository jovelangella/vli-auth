<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class PersonnelController extends Controller
{
    public function folder(Request $request)
    {
        $dtr_date = DB::table('q_payr_dir')
        ->select('strt_dte', 'last_dte')
        ->where('cntrl_no', $request->cntrl_no)
        ->where('primekey', $request->primekey)
        ->first();

        $folder = DB::table('l_dtr_hdr_')
        ->where('l_dtr_hdr_.primekey', $request->primekey)
        ->where('l_day_type.primekey', $request->primekey)
        ->whereBetween('l_dtr_hdr_.dtr_date', [$dtr_date->strt_dte, $dtr_date->last_dte])
        ->join('l_day_type', 'l_day_type.cntrl_no', '=', 'l_dtr_hdr_.day_type')
        ->select('l_dtr_hdr_.cntrl_no','l_dtr_hdr_.dtr_date', 'l_dtr_hdr_.dtr_date as day','l_dtr_hdr_.day_type',
                'l_dtr_hdr_.creat_dt','l_day_type.descript')
        ->orderBy('l_dtr_hdr_.dtr_date')
        ->get();

        return response()->json($folder, 200);
    }

    public function directories(Request $request)
    {
        $directories = DB::table('q_payr_dir')
            ->where('q_payr_dir.primekey', $request->primekey)
            ->where('q_paygroup.primekey', $request->primekey)
            ->join('q_paygroup', 'q_paygroup.group_no', '=', 'q_payr_dir.group_no')
            ->select('q_payr_dir.cntrl_no', 'q_paygroup.descript', 'q_payr_dir.year____', 'q_payr_dir.month___',
                    'q_payr_dir.part____', 'q_payr_dir.seqn_num', 'q_payr_dir.strt_dte', 'q_payr_dir.last_dte',
                    'q_payr_dir.remarks_', 'q_payr_dir.w2_year_', 'q_payr_dir.status__', 'q_payr_dir.appl_prd',
                    'q_payr_dir.dtr_fldr')
            ->get();
        
        return response()->json($directories, 200);
    }

    public function createDtrFolder(Request $request)
    {
        foreach ($request->dateArray as $dateArray) {

            $cntrl_no = $this->maxCntrlNo($request->primekey);
            
            DB::beginTransaction();

            try {
                DB::table('l_dtr_hdr_')
                    ->insert([
                    'primekey' => $request->primekey,
                    'cntrl_no' => $cntrl_no,
                    'dtr_date' => $dateArray,
                    'day_type' => '01',
                    'ttl_empl' => 0,
                    'ttl_err_' => 0,
                    'creat_dt' => Carbon::now()->format('Y-m-d'),
                    'creat_by' => '0000',
                    'compweek' => 'F'
                    ]);

                DB::table('q_payr_dir')
                    ->where('primekey', $request->primekey)
                    ->where('cntrl_no', $request->cntrl_no)
                    ->update([
                        'dtr_fldr' => 'T'
                ]);
            } catch(ValidationException $e)
            {
                // Rollback and then redirect
                // back to form with errors
                DB::rollback();
                return Redirect::to('/form')
                    ->withErrors( $e->getErrors() )
                    ->withInput();
            } catch(\Exception $e)
            {
                DB::rollback();
                throw $e;
            }
            DB::commit();
        }
    }
    
    public function maxCntrlNo($primekey)
    {
        $cntrl_no = DB::table('l_dtr_hdr_')
        ->where('primekey', $primekey)
        ->max('cntrl_no');

        if (!is_null(rtrim($cntrl_no))){
            $cntrl_no = rtrim($cntrl_no);
            $cntrl_no ++;
        } else {
            $cntrl_no = 0;
            $cntrl_no ++;
        }

        return $cntrl_no;
    }
}
