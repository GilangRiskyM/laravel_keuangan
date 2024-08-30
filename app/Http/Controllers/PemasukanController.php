<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditMasukRequest;
use App\Http\Requests\TambahPemasukanRequest;
use App\Models\Masuk;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class PemasukanController extends Controller
{
    function index(Request $request)
    {
        $tanggal = $request->filter_tanggal;

        if ($tanggal == 'hari_ini') {
            $sql = Masuk::whereDate('created_at', Carbon::today())->latest()->paginate(20)->onEachSide(2);
            $sql2 = Masuk::whereDate('created_at', Carbon::today())->get();
        } elseif ($tanggal == 'kemarin') {
            $sql = Masuk::whereDate('created_at', Carbon::yesterday())->latest()->paginate(20)->onEachSide(2);
            $sql2 = Masuk::whereDate('created_at', Carbon::yesterday())->get();
        } elseif ($tanggal == 'minggu_ini') {
            $sql = Masuk::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->latest()->paginate(20)->onEachSide(2);
            $sql2 = Masuk::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        } elseif ($tanggal == 'minggu_lalu') {
            $sql = Masuk::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->latest()->paginate(20)->onEachSide(2);
            $sql2 = Masuk::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->get();
        } elseif ($tanggal == 'bulan_ini') {
            $sql = Masuk::whereMonth('created_at', Carbon::now()->month)->latest()->paginate(20)->onEachSide(2);
            $sql2 = Masuk::whereMonth('created_at', Carbon::now()->month)->get();
        } elseif ($tanggal == 'bulan_lalu') {
            $sql = Masuk::whereMonth('created_at', Carbon::now()->subMonth()->month)->latest()->paginate(20)->onEachSide(2);
            $sql2 = Masuk::whereMonth('created_at', Carbon::now()->subMonth()->month)->get();
        } elseif ($tanggal == 'tahun_ini') {
            $sql = Masuk::whereYear('created_at', Carbon::now()->year)->latest()->paginate(20)->onEachSide(2);
            $sql2 = Masuk::whereYear('created_at', Carbon::now()->year)->get();
        } elseif ($tanggal == 'tahun_lalu') {
            $sql = Masuk::whereYear('created_at', Carbon::now()->subYear()->year)->latest()->paginate(20)->onEachSide(2);
            $sql2 = Masuk::whereYear('created_at', Carbon::now()->subYear()->year)->get();
        } else {
            $sql = Masuk::latest()->paginate(20)->onEachSide(2);
            $sql2 = Masuk::get();
        }

        $total = 0;
        foreach ($sql2 as $data) {
            $total += $data->jumlah_pemasukan;
        }

        return view('pemasukan.index', [
            'sql' => $sql,
            'total' => $total,
            'tanggal' => $tanggal
        ]);
    }

    function create()
    {
        return view('pemasukan.tambah-pemasukan');
    }

    function store(TambahPemasukanRequest $request)
    {
        $request->validated();
        $sql = Masuk::create($request->all());

        if ($sql) {
            Session::flash('status', 'success');
            Session::flash('message', 'Tambah Data Pemasukan Berhasil!!!');
        }

        return redirect('/pemasukan');
    }

    function edit($id)
    {
        $sql = Masuk::findOrFail($id);

        return view('pemasukan.edit-pemasukan', [
            'data' => $sql
        ]);
    }

    function update(EditMasukRequest $request, $id)
    {
        $request->validated();
        $sql = Masuk::findOrFail($id);
        $update = $sql->update($request->all());

        if ($update) {
            Session::flash('status', 'success');
            Session::flash('message', 'Edit Data Pemasukan Berhasil!!!');
        }

        return redirect('/pemasukan');
    }

    function delete($id)
    {
        $sql = Masuk::findOrFail($id);

        return view('pemasukan.hapus-pemasukan', [
            'data' => $sql
        ]);
    }

    function destroy($id)
    {
        $sql = Masuk::findOrFail($id);
        $delete = $sql->delete();

        if ($delete) {
            Session::flash('status', 'success');
            Session::flash('message', 'Hapus Data Pemasukan Berhasil!!!');
        }

        return redirect('/pemasukan');
    }

    function deletedPemasukan()
    {
        $sql = Masuk::onlyTrashed()->latest()->paginate(20);

        return view('pemasukan.data-terhapus', [
            'sql' => $sql
        ]);
    }

    function restoreData($id)
    {
        $sql = Masuk::withTrashed()
            ->where('id', $id)
            ->restore();

        if ($sql) {
            Session::flash('status', 'success');
            Session::flash('message', 'Restore Data Berhasil!!!');
        }

        return redirect('/pemasukan');
    }

    function deletePermanen($id)
    {
        $sql = Masuk::withTrashed()
            ->findOrFail($id);

        return view('pemasukan.hapus_permanen', [
            'data' => $sql
        ]);
    }

    function forceDelete($id)
    {
        $sql = Masuk::withTrashed()
            ->findOrFail($id)
            ->forceDelete();

        if ($sql) {
            Session::flash('status', 'success');
            Session::flash('message', 'Berhasil Hapus Data Pemasukan Secara Permanen!!!');
        }

        return redirect('/pemasukan/restore');
    }
}
