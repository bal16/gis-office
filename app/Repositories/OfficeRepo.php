<?php

namespace App\Repositories;

use App\Models\Office;

class OfficeRepo
{
    /**
     * Returns a query builder which retrieves offices with their districts.
     *
     * The query builder will return a collection of objects with the following properties:
     * - id
     * - name
     * - district_name
     * - longitude
     * - latitude
     * - image
     * - is_district
     *
     * @return Office
     */
    public function getWithDistricts()
    {
        return Office::select('offices.id', 'offices.name', 'districts.name as district_name', 'offices.longitude', 'offices.latitude', 'offices.image', 'offices.is_district')
        ->join('districts', 'districts.id', '=', 'offices.district_id');
    }

    /**
     * Returns a query builder which retrieves offices with their districts,
     * filtered by a search query.
     *
     * The query builder will return a collection of objects with the following properties:
     * - id
     * - name
     * - district_name
     * - longitude
     * - latitude
     * - image
     * - is_district
     *
     * @param string $search
     * @return Office
     */
    public function getFiltered($search)
    {
        return $this->getWithDistricts()
                    ->where('offices.name', 'like', "%$search%")
                    ->orWhere('districts.name', 'like', "%$search%");
    }
}
