<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StdClass extends Model
{
    public function users() 
    {
        return $this->belongsTo(User::class);
    }
    public function students() {
        return $this->hasMany('App\Student');  //$this->hasMany(Student::class)
    }

}
