<?php

namespace App\Http\Controllers;

use App\Models\Keluar;
use App\Models\Masuk;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    function index(Request $request)
    {
        $tanggal = $request->filter_tanggal;

        if ($tanggal == 'hari_ini') {
            $sql = Masuk::whereDate('created_at', Carbon::today())->latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::whereDate('created_at', Carbon::today())->latest()->paginate(20)->onEachSide(2);
            $jumlahMasuk = Masuk::whereDate('created_at', Carbon::today())->get();
            $jumlahKeluar = Keluar::whereDate('created_at', Carbon::today())->get();
        } elseif ($tanggal == 'kemarin') {
            $sql = Masuk::whereDate('created_at', Carbon::yesterday())->latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::whereDate('created_at', Carbon::yesterday())->latest()->paginate(20)->onEachSide(2);
            $jumlahMasuk = Masuk::whereDate('created_at', Carbon::yesterday())->get();
            $jumlahKeluar = Keluar::whereDate('created_at', Carbon::yesterday())->get();
        } elseif ($tanggal == 'minggu_ini') {
            $sql = Masuk::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->latest()->paginate(20)->onEachSide(2);
            $jumlahMasuk = Masuk::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            $jumlahKeluar = Keluar::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        } elseif ($tanggal == 'minggu_lalu') {
            $sql = Masuk::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->latest()->paginate(20)->onEachSide(2);
            $jumlahMasuk = Masuk::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->get();
            $jumlahKeluar = Keluar::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->get();
        } elseif ($tanggal == 'bulan_ini') {
            $sql = Masuk::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->latest()->paginate(20)->onEachSide(2);
            $jumlahMasuk = Masuk::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->get();
            $jumlahKeluar = Keluar::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->get();
        } elseif ($tanggal == 'bulan_lalu') {
            $sql = Masuk::whereMonth('created_at', Carbon::now()->subMonth()->month)->whereYear('created_at', Carbon::now()->year)->latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::whereMonth('created_at', Carbon::now()->subMonth()->month)->whereYear('created_at', Carbon::now()->year)->latest()->paginate(20)->onEachSide(2);
            $jumlahMasuk = Masuk::whereMonth('created_at', Carbon::now()->subMonth()->month)->whereYear('created_at', Carbon::now()->year)->get();
            $jumlahKeluar = Keluar::whereMonth('created_at', Carbon::now()->subMonth()->month)->whereYear('created_at', Carbon::now()->year)->get();
        } elseif ($tanggal == 'tahun_ini') {
            $sql = Masuk::whereYear('created_at', Carbon::now()->year)->latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::whereYear('created_at', Carbon::now()->year)->latest()->paginate(20)->onEachSide(2);
            $jumlahMasuk = Masuk::whereYear('created_at', Carbon::now()->year)->get();
            $jumlahKeluar = Keluar::whereYear('created_at', Carbon::now()->year)->get();
        } elseif ($tanggal == 'tahun_lalu') {
            $sql = Masuk::whereYear('created_at', Carbon::now()->subYear()->year)->latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::whereYear('created_at', Carbon::now()->subYear()->year)->latest()->paginate(20)->onEachSide(2);
            $jumlahMasuk = Masuk::whereYear('created_at', Carbon::now()->subYear()->year)->get();
            $jumlahKeluar = Keluar::whereYear('created_at', Carbon::now()->subYear()->year)->get();
        } else {
            $sql = Masuk::latest()->paginate(20)->onEachSide(2);
            $sql2 = Keluar::latest()->paginate(20)->onEachSide(2);
            $jumlahMasuk = Masuk::get();
            $jumlahKeluar = Keluar::get();
        }

        $totalMasuk = 0;
        $totalKeluar = 0;

        foreach ($jumlahMasuk as $data) {
            $totalMasuk += $data->jumlah_pemasukan;
        }

        foreach ($jumlahKeluar as $data) {
            $totalKeluar += $data->jumlah_pengeluaran;
        }

        $total = $totalMasuk - $totalKeluar;

        return view('laporan.index', [
            'masuk' => $sql,
            'keluar' => $sql2,
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'total' => $total,
            'tanggal' => $tanggal
        ]);
    }
}
