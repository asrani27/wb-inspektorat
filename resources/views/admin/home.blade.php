@extends('layouts.master')

@section('content')
@if (session()->has('success'))
<div class="col-lg-12">
    <div class="alert alert-important alert-success alert-dismissible" role="alert">
        <div class="d-flex">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M5 12l5 5l10 -10"></path>
                </svg>
            </div>
            <div>
                {{ session()->get('success') }}
            </div>
        </div>
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
</div>
@endif

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Overview
                </div>
                <h2 class="page-title">
                    Data Pengaduan
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <a href="/admin/pengaduan/add" class="btn btn-outline-primary w-100">Tambah Data</a>
            </div>
        </div>
    </div>
</div>
{{-- <form method="get" action="/admin/home/filter">
    @csrf
    <div class="row g-3">
        <div class="col-md">
            <div class="form-label">Sektor</div>
            <select class="form-control" name="sektor_id">
                <option value="" {{ old('sektor_id')==null ? 'selected' : '' }}>-semua-</option>
                @foreach ($sektor as $item)
                <option value="{{ $item->id }}" {{ old('sektor_id')==$item->id ? 'selected' : '' }}>
                    {{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md">
            <div class="form-label">Status</div>
            <select class="form-control" name="status">
                <option value="" {{ old('status')===null ? 'selected' : '' }}>-semua-</option>
                <option value="0" {{ old('status')==='0' ? 'selected' : '' }}>DRAF</option>
                <option value="1" {{ old('status')==='1' ? 'selected' : '' }}>DIKIRIM</option>
                <option value="2" {{ old('status')==='2' ? 'selected' : '' }}>TERVALIDASI</option>
                <option value="3" {{ old('status')==='3' ? 'selected' : '' }}>TIDAK VALID</option>
            </select>
        </div>
        <div class="col-md">
            <div class="form-label"><br /></div>
            <button type="submit" class='btn btn-md btn-primary'><svg xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                    <path d="M21 21l-6 -6" />
                </svg> FILTER</button>
        </div>
    </div>
</form> --}}
<div class="col-12">
    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Telp</th>
                        <th>Email</th>
                        <th>Isi Aduan</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                    <tr>
                        <td>{{ $data->firstItem() + $key }}</td>
                        <td>{{$item->nama}}</td>
                        <td>{{$item->nip}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{$item->telp}}</td>
                        <td>{{$item->isi}}</td>
                        <td>
                            @if ($item->status == 0)
                            <span class="badge badge-outline text-blue">BARU MASUK</span>
                            @endif
                            @if ($item->status == 1)
                            <span class="badge badge-outline text-red">DI PROSES</span>
                            @endif
                            @if ($item->status == 2)
                            <span class="badge badge-outline text-green">SELESAI</span>
                            @endif
                        </td>

                        <td>

                            <div class="row g-2 align-items-center">
                                @if ($item->status == 0)
                                <div class="col-6">
                                    <a href="/admin/pengaduan/proses/{{ $item->id }}"
                                        class="btn btn-outline-success w-100"
                                        onclick="return confirm('Yakin ingin Diproses?');">Proses</a>
                                </div>
                                @endif
                                @if ($item->status == 1)
                                <div class="col-6">
                                    <a href="/admin/pengaduan/selesai/{{ $item->id }}"
                                        class="btn btn-outline-success w-100"
                                        onclick="return confirm('Yakin ingin Diselesaikan?');">selesai</a>
                                </div>
                                @endif
                                <div class="col-6">
                                    <a href="/admin/pengaduan/delete/{{ $item->id }}"
                                        class="btn btn-outline-danger w-100"
                                        onclick="return confirm('Yakin ingin Dihapus?');">Hapus</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
{{$data->links()}}
@endsection

@push('js')
@endpush