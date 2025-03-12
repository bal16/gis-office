<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Repositories\OfficeRepo;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    protected $officeRepo;
    public function __construct()
    {
        $this->officeRepo = new OfficeRepo();
    }

    public function index(Request $request)
    {
        $perpage = $request->perpage ?? 10;
        $search = $request->q ?? '';

        $offices = $this->officeRepo->getFiltered($search)
                                    ->paginate($perpage);
        return view('index', [
            'offices' => $offices
        ]);
    }

    public function api(Request $request)
    {
        $perpage = $request->perpage ?? 10;
        $search = $request->q ?? '';

        $offices = $this->officeRepo->getFiltered($search)
                                    ->paginate($perpage);
        return response()->json($offices);
    }

}
