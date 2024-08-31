@extends('layouts.app')
@include('fungsi.fungsi_tgl_indo')
@section('title', 'Elmuna - Pemasukan')
@section('content')
    <center>
        <h1 class="my-3">Pemasukan</h1>
    </center>
    @if (Session::has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="my-3">
        <a href="/pemasukan/tambah" class="btn btn-primary">Tambah Data</a>
        <a href="/pemasukan/restore" class="btn btn-secondary">Restore Data</a>
    </div>
    <hr>
    <div class="col-md-6">
        <label class="mb-2">Filter Data</label>
        <form action="/pemasukan" method="get">
            <div class="input-group">
                <span class="input-group-text">Pilih Data</span>
                <select name="filter_tanggal" id="" class="form-select">
                    <option value="" {{ $tanggal == '' ? 'selected' : null }}>Semua Data</option>
                    <option value="hari_ini" {{ $tanggal == 'hari_ini' ? 'selected' : null }}>Hari Ini</option>
                    <option value="kemarin" {{ $tanggal == 'kemarin' ? 'selected' : null }}>Kemarin</option>
                    <option value="minggu_ini" {{ $tanggal == 'minggu_ini' ? 'selected' : null }}>Minggu Ini</option>
                    <option value="minggu_lalu" {{ $tanggal == 'minggu_lalu' ? 'selected' : null }}>Minggu Lalu</option>
                    <option value="bulan_ini" {{ $tanggal == 'bulan_ini' ? 'selected' : null }}>Bulan Ini</option>
                    <option value="bulan_lalu" {{ $tanggal == 'bulan_lalu' ? 'selected' : null }}>Bulan Lalu</option>
                    <option value="tahun_ini" {{ $tanggal == 'tahun_ini' ? 'selected' : null }}>Tahun Ini</option>
                    <option value="tahun_lalu" {{ $tanggal == 'tahun_lalu' ? 'selected' : null }}>Tahun Lalu</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="/pemasukan" class="btn btn-danger">Batal</a>
            </div>
        </form>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr class="align-middle">
                    <th>No.</th>
                    <th>Keterangan Pemasukan</th>
                    <th>Tanggal</th>
                    <th>Jumlah Pemasukan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1 + ($sql->currentPage() - 1) * $sql->perPage();
                @endphp
                @if ($sql->count() > 0)
                    @foreach ($sql as $datum)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $datum->ket_pemasukan }}</td>
                            <td>{{ tgl_indonesia3($datum->created_at) }}</td>
                            <td>Rp. {{ $datum->jumlah_pemasukan }} ,-</td>
                            <td>
                                <a href="/pemasukan/edit/{{ $datum->id }}" class="btn btn-warning">Edit</a>
                                <a href="/pemasukan/hapus/{{ $datum->id }}" class="btn btn-danger my-2">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">
                            <center>
                                <h3>Data Kosong</h3>
                            </center>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        {{ $sql->appends(request()->query())->links() }}
    </div>
    <hr>
    <h3>Total Pemasukan = Rp. {{ $total }} ,-</h3>
@endsection
