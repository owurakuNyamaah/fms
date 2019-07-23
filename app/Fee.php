<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    public function students()
    {
        return $this->belongsTo(Student::class);
    }
    
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
