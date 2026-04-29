<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Duck extends Model
{
    protected $fillable = 
        ['name', 'species', 
            'band_number', 'park_id'];

    public function park(){
        return $this->belongsTo(Park::class);
    }
}
