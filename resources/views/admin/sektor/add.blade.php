@extends('layouts.master')

@section('content')
  
<div class="col-12">
    <form class="card" method="POST" action="/admin/sektor/add" enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <h3 class="card-title">
              sektor
            </h3>
            <div class="card-actions">
              <a href="/admin/sektor">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-big-left-lines"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 15v3.586a1 1 0 0 1 -1.707 .707l-6.586 -6.586a1 1 0 0 1 0 -1.414l6.586 -6.586a1 1 0 0 1 1.707 .707v3.586h3v6h-3z" /><path d="M21 15v-6" /><path d="M18 15v-6" /></svg>
                Back <!-- Download SVG icon from http://tabler-icons.io/i/edit -->
              </a>
            </div>
        </div>

        <div class="card-body">
                <div class="row row-cards">
                    <div class="col-sm-6 col-md-6">
                        <div class="mb-3">
                        <label class="form-label">Nama sektor</label>
                        <input type="text" class="form-control" name="nama" placeholder="Nama sektor" required>
                        </div>
                    </div>
                </div>

        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
  </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

@endpush