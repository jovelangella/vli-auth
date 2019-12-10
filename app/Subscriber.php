<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    /**
     * change Subscriber model pointer to s_vli_subs
     */
    protected $table = 's_vli_subs';

    protected $primaryKey = 'cntrl_no';

    public $incrementing = false;

    public $timestamps = false;

}
