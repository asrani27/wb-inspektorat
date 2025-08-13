@extends('layouts.master')

@push('css')

@section('content')
@if(session()->has('success'))
  <div class="col-lg-12">
    <div class="alert alert-important alert-success alert-dismissible" role="alert">
      <div class="d-flex">
        <div>
          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
        </div>
        <div>
          {{ session()->get('success') }}
        </div>
      </div>
      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
  </div>
  @endif
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          Setting
        </h3>
        <div class="card-actions">
        </div>
      </div>
      <div class="card-body">
        <form method="post" action="/admin/setting">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tampilkan Gambar Untuk IG</label>
            <select type="text" class="form-select" name="is_aktif">
              <option value="Y" {{$data->is_aktif == 'Y' ? 'selected':''}}>Ya</option>
              <option value="T" {{$data->is_aktif == 'T' ? 'selected':''}}>Tidak</option>
            </select>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@push('js')

@endpush