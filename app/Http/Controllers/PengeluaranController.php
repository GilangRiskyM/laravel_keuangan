<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditKeluarRequest;
use App\Http\Requests\TambahPengeluaranRequest;
use App\Models\Keluar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class PengeluaranController extends Controller
{
    function index(Request $request)
    {
        $tanggal = $request->filter_tanggal;

        if ($tanggal == 'hari_ini') {
            $sql = Keluar::whereDate('created_at', Carbon::today())->latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::whereDate('created_at', Carbon::today())->get();
        } elseif ($tanggal == 'kemarin') {
            $sql = Keluar::whereDate('created_at', Carbon::yesterday())->latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::whereDate('created_at', Carbon::yesterday())->get();
        } elseif ($tanggal == 'minggu_ini') {
            $sql = Keluar::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        } elseif ($tanggal == 'minggu_lalu') {
            $sql = Keluar::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->get();
        } elseif ($tanggal == 'bulan_ini') {
            $sql = Keluar::whereMonth('created_at', Carbon::now()->month)->latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::whereMonth('created_at', Carbon::now()->month)->get();
        } elseif ($tanggal == 'bulan_lalu') {
            $sql = Keluar::whereMonth('created_at', Carbon::now()->subMonth()->month)->latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::whereMonth('created_at', Carbon::now()->subMonth()->month)->get();
        } elseif ($tanggal == 'tahun_ini') {
            $sql = Keluar::whereYear('created_at', Carbon::now()->year)->latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::whereYear('created_at', Carbon::now()->year)->get();
        } elseif ($tanggal == 'tahun_lalu') {
            $sql = Keluar::whereYear('created_at', Carbon::now()->subYear()->year)->latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::whereYear('created_at', Carbon::now()->subYear()->year)->get();
        } else {
            $sql = Keluar::latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::get();
        }

        $total = 0;
        foreach ($sql2 as $data) {
            $total += $data->jumlah_pengeluaran;
        }

        return view('pengeluaran.index', [
            'sql' => $sql,
            'total' => $total,
            'tanggal' => $tanggal
        ]);
    }

    function create()
    {
        return view('pengeluaran.tambah-pengeluaran');
    }

    function store(TambahPengeluaranRequest $request)
    {
        $request->validated();
        $sql = Keluar::create($request->all());

        if ($sql) {
            Session::flash('status', 'success');
            Session::flash('message', 'Tambah Data Pengeluaran Berhasil!!!');
        }

        return redirect('/pengeluaran');
    }

    function edit($id)
    {
        $sql = Keluar::findOrFail($id);

        return view('pengeluaran.edit-pengeluaran', [
            'data' => $sql
        ]);
    }

    function update(EditKeluarRequest $request, $id)
    {
        $request->validated();
        $sql = Keluar::findOrFail($id);
        $update = $sql->update($request->all());

        if ($update) {
            Session::flash('status', 'success');
            Session::flash('message', 'Edit Data Pengeluaran Berhasil!!!');
        }

        return redirect('/pengeluaran');
    }

    function delete($id)
    {
        $sql = Keluar::findOrFail($id);

        return view('pengeluaran.hapus-pengeluaran', [
            'data' => $sql
        ]);
    }

    function destroy($id)
    {
        $sql = Keluar::findOrFail($id);
        $delete = $sql->delete();

        if ($delete) {
            Session::flash('status', 'success');
            Session::flash('message', 'Hapus Data Pengeluaran Berhasil!!!');
        }

        return redirect('/pengeluaran');
    }

    function deletedPengeluaran()
    {
        $sql = Keluar::onlyTrashed()->latest()->paginate(20);

        return view('pengeluaran.data-terhapus', [
            'sql' => $sql
        ]);
    }

    function restoreData($id)
    {
        $sql = Keluar::withTrashed()
            ->where('id', $id)
            ->restore();

        if ($sql) {
            Session::flash('status', 'success');
            Session::flash('message', 'Restore Data Berhasil!!!');
        }

        return redirect('/pengeluaran');
    }

    function deletePermanen($id)
    {
        $sql = Keluar::withTrashed()
            ->findOrFail($id);

        return view('pengeluaran.hapus_permanen', [
            'data' => $sql
        ]);
    }

    function forceDelete($id)
    {
        $sql = Keluar::withTrashed()
            ->findOrFail($id)
            ->forceDelete();

        if ($sql) {
            Session::flash('status', 'success');
            Session::flash('message', 'Berhasil Hapus Data Pengeluaran Secara Permanen!!!');
        }

        return redirect('/pengeluaran/restore');
    }
}
