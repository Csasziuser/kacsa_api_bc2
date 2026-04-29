<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    //protected $table = 'parks';

    protected $fillable = 
        ['name','district', 'pond_count'];

    public function ducks(){
        return $this->hasMany(Duck::class);
    }
}
