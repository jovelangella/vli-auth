<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\SystemControl;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Subscriber;
use App\Models\UserAssign;
use Carbon\Carbon;
use DB;

class AuthController extends Controller
{
    public $succsesStatus = 200;

    public function login(Request $request)
    {
        /**
         * requesting access token
         */
        $http = new \GuzzleHttp\Client();

        try {
            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->username,
                    'password' => $request->password,
                    'scope' => '',
                ],
            ]);

            return $response->getBody();
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return $e->getResponse()->getBody()->getContents();
        }
    }

    public function register(Request $request)
    {
        /**
         * for admin only - approval
         */
        /**
         * validate request
         */
        $request->validate([
            'user_id_' => 'unique:s_vli_subs_users',
            'user_pwd' => 'required',
        ]);

        /**
         * get current vli_subs of current authenticated user
         */
        $vli_subs = auth('api')->user()->vli_subs;

        /**
         * select maximum user_num per vli_subs
         */
        $user_num = User::where('vli_subs', $vli_subs)
            ->max('user_num');
        $user_num++;

        /**
         * get client prefix
         */
        $clnt_pre = Subscriber::where('cntrl_no', $vli_subs)
            ->value('clnt_pre');

        /**
         * parse integer in username / user_id_ VLI[000] <---
         * create user_id_ + user_num = [VLI] + [001]
         */
        $user_num = sprintf("%'.03d", $user_num);
        $user_id_ = rtrim($clnt_pre).$user_num;

        /**
         * create user/s per vli_subs ID
         */
        return User::create([
            'vli_subs' => $vli_subs,
            'user_num' => $user_num,
            'user_id_' => $user_id_,
            'empl_cde' => $request->empl_cde,
            'user_nme' => $request->user_nme,
            'user_pwd' => Hash::make($request->user_pwd),
            'disabled' => 'F',
            'added_dt' => Carbon::now()->format('Y-m-d')
        ]);
    }
    
    // s_vli_subs_user_asgn
    public function userAssigned(Request $request)
    {  
        $primekey = UserAssign::where([['vli_subs', $request->vli_subs], ['user_num', $request->user_num]])
                        ->value('primekey');
        
        return response()->json(['primekey' => $primekey], 200);
    }

    // s_sys_ctrl
    public function userAssignedCompany(Request $request)
    {
        // if component requires array, do not return this to json file instead return array
        return SystemControl::select('primekey','co_name_')->where('primekey', $request->primekey)->get();

    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);
    }
}
