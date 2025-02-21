<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'name'
        ];


    public function offices(){
        return $this->hasMany(Office::class);
    }
}
