<?php

namespace App\Repositories;

use App\Models\Office;

class OfficeRepo
{
    public function getWithDistricts()
    {
        return Office::select('offices.id', 'offices.name', 'districts.name as district_name', 'offices.longitude', 'offices.latitude', 'offices.image', 'offices.is_district')
        ->join('districts', 'districts.id', '=', 'offices.district_id');
    }

    public function getFiltered($search)
    {
        return $this->getWithDistricts()
                    ->where('offices.name', 'like', "%$search%")
                    ->orWhere('districts.name', 'like', "%$search%");
    }
}
