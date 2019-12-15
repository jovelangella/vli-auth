<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAssign extends Model
{
    /**
     * change Client model pointer to s_vli_subs_users_asgn
     */
    protected $table = 's_vli_subs_users_asgn';

    protected $primaryKey = 'primekey';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];

    // protected function setKeysForSaveQuery(Builder $query)
    // {
    //     $keys = $this->getKeyName();
    //     if(!is_array($keys)){
    //         return parent::setKeysForSaveQuery($query);
    //     }

    //     foreach($keys as $keyName){
    //         $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
    //     }

    //     return $query;
    // }

    // /**
    //  * Get the primary key value for a save query.
    //  *
    //  * @param mixed $keyName
    //  * @return mixed
    //  */
    // protected function getKeyForSaveQuery($keyName = null)
    // {
    //     if(is_null($keyName)){
    //         $keyName = $this->getKeyName();
    //     }

    //     if (isset($this->original[$keyName])) {
    //         return $this->original[$keyName];
    //     }

    //     return $this->getAttribute($keyName);
    // }
}
