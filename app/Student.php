<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function stdClass() {
        return $this->belongsTo('App\StdClass');
    }

}
