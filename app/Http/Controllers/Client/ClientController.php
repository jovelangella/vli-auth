<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Carbon\Carbon;

class ClientController extends Controller
{
    public function register(Request $request)
    {
        // $validatedData  = $request->validate([
        //     'com_name' => ['max:100', 'unique:s_vli_register'],
        //     'address_' => ['max:200'],
        //     'frst_nme' => ['required'],
        //     'last_nme' => ['required'],
        //     'cel_numb' => ['required', 'unique:s_vli_register'],
        //     'emailadr' => ['required', 'unique:s_vli_register'],
        //     'approved' => ['required'],
        // ]);

        return Client::create([
            'com_name' => $request->com_name,
            'address_' => $request->address_,
            'frst_nme' => $request->frst_nme,
            'last_nme' => $request->last_nme,
            'cel_numb' => $request->cel_numb,
            'emailadr' => $request->emailadr,
            'approved' => 'F',
            'added_dt' => Carbon::now()->format('Y-m-d')
        ]);
    }
}
