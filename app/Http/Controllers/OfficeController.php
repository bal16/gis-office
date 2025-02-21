<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index(Request $request)
    {
        $perpage = $request->perpage ?? 10;
        $search = $request->q ?? '';

        $offices = Office::customIndex($search)->paginate($perpage)->withQueryString();
        return view('index', [
            'offices' => $offices
        ]);
    }

    public function api(Request $request)
    {
        $perpage = $request->perpage ?? 10;
        $search = $request->q ?? '';

        $offices = Office::customIndex($search)->paginate($perpage)->withQueryString();

        return response()->json($offices);
    }

}
