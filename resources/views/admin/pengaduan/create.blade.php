@extends('layouts.master')

@section('content')

<div class="col-12">
    <form class="card" method="POST" action="/admin/pengaduan/add" enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <h3 class="card-title">
                Tambah Aduan
            </h3>
            <div class="card-actions">
                <a href="/admin/home">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-big-left-lines">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M12 15v3.586a1 1 0 0 1 -1.707 .707l-6.586 -6.586a1 1 0 0 1 0 -1.414l6.586 -6.586a1 1 0 0 1 1.707 .707v3.586h3v6h-3z" />
                        <path d="M21 15v-6" />
                        <path d="M18 15v-6" />
                    </svg>
                    Back To Home
                    <!-- Download SVG icon from http://tabler-icons.io/i/edit -->
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row row-cards">
                <div class="col-sm-12 col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="Nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIP</label>
                        <input type="text" class="form-control" name="nip" placeholder="nip" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">telp</label>
                        <input type="text" class="form-control" name="telp" placeholder="telp" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">email</label>
                        <input type="text" class="form-control" name="email" placeholder="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">isi aduan</label>
                        <textarea class="form-control" rows="4" name="isi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">status</label>
                        <select class="form-control" name="status" required>
                            <option value="0">BARU MASUK</option>
                            <option value="1">DIPROSES</option>
                            <option value="2">SELESAI</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Kirim Aduan</button>
        </div>
    </form>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

@endpush