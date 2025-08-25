@extends('layouts.master')

@section('content')
<div class="row">
    @if (session()->has('success'))
    <div class="col-lg-12">
        <div class="alert alert-important alert-success alert-dismissible" role="alert">
            <div class="d-flex">
                <div>
                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
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

    @if (session()->has('error'))
    <div class="col-lg-12">
        <div class="alert alert-important alert-danger alert-dismissible" role="alert">
            <div class="d-flex">
                <div>
                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-square-x">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M19 2h-14a3 3 0 0 0 -3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3 -3v-14a3 3 0 0 0 -3 -3zm-9.387 6.21l.094 .083l2.293 2.292l2.293 -2.292a1 1 0 0 1 1.497 1.32l-.083 .094l-2.292 2.293l2.292 2.293a1 1 0 0 1 -1.32 1.497l-.094 -.083l-2.293 -2.292l-2.293 2.292a1 1 0 0 1 -1.497 -1.32l.083 -.094l2.292 -2.293l-2.292 -2.293a1 1 0 0 1 1.32 -1.497z" />
                    </svg>
                </div>
                <div>
                    {{ session()->get('error') }}
                </div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    </div>
    @endif
</div>


<div class="col-12">
    <span class="badge badge-outline text-red">Note : Setelah mengirim aduan, anda dapat melihat status aduan anda,
        namun tidak bisa mengedit maupun menghapus aduan yang telah di kirim</span>
    <br /><br />
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Pengaduan</h3>

            <div class="card-actions">
                <a href="/user/pengaduan/add" class="btn btn-primary">
                    Tambah Pengaduan
                    <!-- Download SVG icon from http://tabler-icons.io/i/edit -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                        </path>
                        <path d="M16 5l3 3"></path>
                    </svg>
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                        <th class="w-1">No.
                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm icon-thick" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M6 15l6 -6l6 6" />
                            </svg>
                        </th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Telp</th>
                        <th>Isi Aduan</th>
                        <th>Status</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengaduan as $key => $item)
                    <tr>
                        <td><span class="text-secondary">{{$key + 1}}</span></td>
                        <td>{{$item->nama}}</td>
                        <td>{{$item->nip}}</td>
                        <td>{{$item->telp}}</td>
                        <td>
                            {{ str($item->isi)->limit(500, '...') }}
                        </td>
                        <td>
                            @if ($item->status == 0)

                            <span class="badge bg-blue me-1"></span> Di kirim
                            @endif
                            @if ($item->status == 1)

                            <span class="badge bg-danger me-1"></span> Diproses
                            @endif
                            @if ($item->status == 2)

                            <span class="badge bg-success me-1"></span> Selesai
                            @endif
                        </td>
                        {{-- <td class="text-end">
                            <a class="btn btn-outline-danger" href="/user/pengaduan/delete/{{$item->id}}"
                                onclick="return confirm('Are you sure you want to delete this item')">
                                Hapus
                            </a>
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">

        </div>
    </div>
</div>

</div>




@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@endpush