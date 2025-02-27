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
                Storage::disk('public')->delete($model->getOriginal('image'));
            }
        });
    }

    public function district(){
        return $this->belongsTo(District::class);
    }


    /**
     * Retrieves a list of offices, including their associated district names,
     * filtered by a search term. The search is performed on the office name
     * and district name.
     *
     * @param string $search The search term to filter office and district names.
     * @return \App\Models\Office The Office model as a query builder instance with the applied filters.
     */
    public static function customIndex($search){
        $offices = static::select('offices.id', 'offices.name', 'districts.name as district_name', 'offices.longitude', 'offices.latitude', 'offices.image')
                        ->join('districts', 'districts.id', '=', 'offices.district_id')
                        ->where('offices.name', 'like', "%$search%")
                        ->orWhere('districts.name', 'like', "%$search%");

        return $offices;
    }
}
