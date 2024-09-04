<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditKuitansiRequest;
use App\Http\Requests\TambahKuitansiRequest;
use App\Models\Masuk;
use App\Models\Kuitansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KuitansiController extends Controller
{
    function index(Request $request)
    {
        $sql = Kuitansi::latest()->paginate(20)->onEachSide(2);
        return view('kuitansi.index', [
            'data' => $sql,
        ]);
    }

    function create($id)
    {
        $sql = Masuk::findOrFail($id);
        return view('kuitansi.tambah', ['data' => $sql]);
    }

    function store(TambahKuitansiRequest $request)
    {
        $request->validated();
        $sql = Kuitansi::create($request->all());

        if ($sql) {
            Session::flash('status', 'success');
            Session::flash('message', 'Tambah Data Kuitansi Berhasil!!!');
        }

        return redirect('/kuitansi');
    }

    function edit($id)
    {
        $sql = Kuitansi::findOrFail($id);
        return view('kuitansi.edit', ['data' => $sql]);
    }

    function update(EditKuitansiRequest $request, $id)
    {
        $request->validated();
        $sql = Kuitansi::findOrFail($id);
        $update = $sql->update($request->all());

        if ($update) {
            Session::flash('status', 'success');
            Session::flash('message', 'Edit Data Kuitansi Berhasil!!!');
        }

        return redirect('/kuitansi');
    }

    function cetakKuitansi($id)
    {
        $sql = Kuitansi::findOrFail($id);
        return view('kuitansi.cetak', ['data' => $sql]);
    }
}
