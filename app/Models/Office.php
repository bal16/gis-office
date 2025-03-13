<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Office extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'district_id',
        'is_district',
        'longitude',
        'latitude',
        'image',
    ];

    protected static function boot(){
        parent::boot();
        static::updating(function ($model) {
            if($model->isDirty('image') && ($model->getOriginal('image') !== null)) {
                Storage::delete($model->getOriginal('image'));
            }
        });
    }

    public function district(){
        return $this->belongsTo(District::class);
    }

}
