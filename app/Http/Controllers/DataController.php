<?php

namespace App\Http\Controllers;

use App\Models\DataModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{
    public function index()
    {
        $data = DataModel::orderBy('Tanggal Retur', 'desc')->get();
        // dd($data);
        return view('dashboard' , compact('data'));
    }

    public function api()
    {
        $model = DataModel::all();
        if($model) {
            return response()->json([
                'success' => true,
                'data' => $model
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => null
            ]);
        }
    }
}
