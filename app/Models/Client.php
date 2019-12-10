<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * change Client model pointer to s_vli_register
     */
    protected $table = 's_vli_register';

    protected $primaryKey = 'cntrl_no';

    public $incrementing = true;

    public $timestamps = false;

    protected $guarded = [];

}
