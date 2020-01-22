<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemControl extends Model
{
    /**
     * change Client model pointer to s_sys_ctrl
     */
    protected $table = 's_sys_ctrl';

    protected $primaryKey = 'primekey';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];
}
