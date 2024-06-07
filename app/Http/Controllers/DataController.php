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

    public function form()
    {
        return view('form');
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'namaBarang' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'penyebab' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'tanggalRetur' => 'required|date',
        ]);

        // Simpan data ke model DataModel
        DataModel::create([
            'Nama Barang' => $request->namaBarang,
            'Jumlah' => $request->jumlah,
            'Penyebab' => $request->penyebab,
            'Status' => $request->status,
            'Keterangan' => $request->keterangan,
            'Tanggal Retur' => $request->tanggalRetur
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil terkirim!']);
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
