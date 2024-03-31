<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function states()
    {
        return $this->hasMany('App\State', 'country_id');
    }

    public function cities()
    {
        return $this->hasMany('App\City');
    }

}
