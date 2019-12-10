<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * change User model pointer to s_vli_subs_users
     */
    protected $table = 's_vli_subs_users';

    protected $primaryKey = 'user_id_';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    /**
     * pass the value of user_id_ to laravel passport username field
     */
    public function findForPassport($username)
    {
        return $this->where('user_id_', $username)->first();
    }

    /**
     * pass the value of user_pwd to laravel passport password field
     */
    public function validateForPassportPasswordGrant($password)
    {
        return Hash::check($password, $this->user_pwd);
    }

    public function vliSubsID()
    {
        return $this->vli_subs;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
}
