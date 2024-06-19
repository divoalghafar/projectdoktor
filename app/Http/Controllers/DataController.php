<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\DataModel;
use App\Models\Marketing;
use App\Models\Pengemasan;
use App\Models\Operasional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{

    // Manajemen Resiko - Retur
    public function dashboardManajemenResiko()
    {
        $data = DataModel::orderBy('Tanggal Retur', 'desc')->get();
        // dd($data);
        return view('dashboardmanajemenresiko' , compact('data'));
    }

    public function formManajemenResiko()
    {
        return view('formmanajemenresiko');
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

    public function home()
    {
        return view('home');
    }


    // Marketing

    public function formMarketing()
    {
        return view('formmarketing');
    }

    public function formMarketingSave(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'biaya' => 'required|integer',
            'biayabulan' => 'required|date',
            'totalbiaya' => 'required|integer',
            'tanggalmarketing' => 'required|date',
        ]);

        // Simpan data ke model DataModel
        Marketing::create([
            'kategori' => $request->kategori,
            'kode' => $request->kode,
            'keterangan' => $request->keterangan,
            'biaya' => $request->biaya,
            'biaya_bulan' => $request->biayabulan,
            'total_biaya' => $request->totalbiaya,
            'tanggal_marketing' => $request->tanggalmarketing
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil terkirim!']);
    }

    public function apiMarketing()
    {
        $marketing = Marketing::all();
        if($marketing) {
            return response()->json([
                'success' => true,
                'data' => $marketing
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => null
            ]);
        }
    }

    // Operasional

    public function formOperasional()
    {
        return view('formoperasional');
    }

    public function formOperasionalSave(Request $request)
    {
        // dd($request);
        $request->validate([
            'kategori' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'biaya' => 'required|integer',
            'qty' => 'required|integer',
            'jumlah' => 'required|integer',
            'biayabulan' => 'required|date',
            'totalbiaya' => 'required|integer',
            'tanggaloperasional' => 'required|date'
        ]);

        // Simpan data ke model DataModel
        Operasional::create([
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan,
            'biaya' => $request->biaya,
            'qty' => $request->qty,
            'jumlah' => $request->jumlah,
            'biaya_bulan' => $request->biayabulan,
            'total_biaya' => $request->totalbiaya,
            'tanggal_operasional' => $request->tanggaloperasional
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil terkirim!']);
    }

    public function apiOperasional()
    {
        $operasional = Operasional::all();
        if($operasional) {
            return response()->json([
                'success' => true,
                'data' => $operasional
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => null
            ]);
        }
    }

    // Aset

    public function formAset()
    {
        return view('formaset');
    }

    public function formAsetSave(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'biaya' => 'required|integer',
            'qty' => 'required|integer',
            'jumlah' => 'required|integer',
            'biayabulan' => 'required|date',
            'totalbiaya' => 'required|integer',
            'tanggalaset' => 'required|date'
        ]);

        // Simpan data ke model DataModel
        Aset::create([
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan,
            'biaya' => $request->biaya,
            'qty' => $request->qty,
            'jumlah' => $request->jumlah,
            'biaya_bulan' => $request->biayabulan,
            'total_biaya' => $request->totalbiaya,
            'tanggal_aset' => $request->tanggalaset
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil terkirim!']);
    }

    public function apiAset()
    {
        $aset = Aset::all();
        if($aset) {
            return response()->json([
                'success' => true,
                'data' => $aset
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => null
            ]);
        }
    }
    
    // Pengemasan

    public function formPengemasan()
    {
        return view('formpengemasan');
    }

    public function formPengemasanSave(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'ecommerce' => 'required|string|max:255',
            'biaya' => 'required|integer',
            'qty' => 'required|integer',
            'jumlah' => 'required|integer',
            'biayabulan' => 'required|date',
            'totalbiaya' => 'required|integer',
            'tanggalpengemasan' => 'required|date'
        ]);

        // Simpan data ke model DataModel
        Pengemasan::create([
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan,
            'ecommerce' => $request->ecommerce,
            'biaya' => $request->biaya,
            'qty' => $request->qty,
            'jumlah' => $request->jumlah,
            'biaya_bulan' => $request->biayabulan,
            'total_biaya' => $request->totalbiaya,
            'tanggal_pengemasan' => $request->tanggalpengemasan
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil terkirim!']);
    }

}
