@extends('layouts.master')

@section('content')
  
<div class="col-12">
    <form class="card" method="POST" action="/user/home/editprofile" enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <h3 class="card-title">
              Profile
            </h3>
            <div class="card-actions">
              <a href="/user/home">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-big-left-lines"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 15v3.586a1 1 0 0 1 -1.707 .707l-6.586 -6.586a1 1 0 0 1 0 -1.414l6.586 -6.586a1 1 0 0 1 1.707 .707v3.586h3v6h-3z" /><path d="M21 15v-6" /><path d="M18 15v-6" /></svg>
                Back To Home<!-- Download SVG icon from http://tabler-icons.io/i/edit -->
              </a>
            </div>
        </div>

        <div class="card-body">
                <div class="row row-cards">
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">NIK</label>
                    <input type="text" class="form-control" name="nik" placeholder="NIK" value="{{$data == null ? null : $data->nik}}" required maxlength="16" minlength="16">
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">NO KK</label>
                    <input type="text" class="form-control" name="nokk" placeholder="no kk" value="{{$data == null ? null : $data->nokk}}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" placeholder="Nama Lengkap" value="{{$data == null ? null : $data->nama_lengkap}}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Nama Panggilan</label>
                    <input type="text" class="form-control" name="nama_panggilan" placeholder="Nama Panggilan" value="{{$data == null ? null : $data->nama_panggilan}}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Kewarganegaraan</label>
                    <input type="text" class="form-control" name="kewarganegaraan" placeholder="Indonesia" value="{{$data == null ? null : $data->kewarganegaraan}}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select class="form-control" required name="jkel" >
                            <option value="">-pilih-</option>
                            <option value="L" {{($data == null ? null : $data->jkel) == 'L' ? 'selected':'' }}>Pria</option>
                            <option value="P" {{($data == null ? null : $data->jkel) == 'P' ? 'selected':'' }}>Wanita</option>
                    </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir" placeholder="Tanggal" value="{{$data == null ? null : $data->tanggal_lahir}}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" name="tempat_lahir" placeholder="Tempat Lahir" value="{{$data == null ? null : $data->tempat_lahir}}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Status Menikah</label>
                    <select class="form-control" required name="status_menikah">
                        <option value="">-pilih-</option>
                        <option value="T" {{$data->status_menikah == 'T' ? 'selected':''}}>Belum Menikah</option>
                        <option value="Y" {{$data->status_menikah == 'Y' ? 'selected':''}}>Menikah</option>
                    </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Telp</label>
                    <input type="text" class="form-control" name="telp" placeholder="Telp" value="{{$data == null ? null : $data->telp}}" required>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="mb-3">
                    <label class="form-label">Alamat Sesuai KTP</label>
                    <input type="text" class="form-control" name="alamat_ktp" placeholder="alamat sesuai KTP" value="{{$data == null ? null : $data->alamat_ktp}}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Kabupaten/Kota Sesuai KTP</label>
                    <input type="text" class="form-control" name="kota_ktp" placeholder="kota sesuai KTP" value="{{$data == null ? null : $data->kota_ktp}}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Kodepos Sesuai KTP</label>
                    <input type="text" class="form-control" name="kodepos_ktp" placeholder="Kodepos sesuai KTP" value="{{$data == null ? null : $data->kodepos_ktp}}" required>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="mb-3">
                    <label class="form-label">Alamat Saat Ini</label>
                    <input type="text" class="form-control" name="alamat_saat_ini" placeholder="alamat Saat Ini" value="{{$data == null ? null : $data->alamat_saat_ini}}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Kabupaten/Kota Saat Ini</label>
                    <input type="text" class="form-control" name="kota_saat_ini" placeholder="kota Saat Ini" value="{{$data == null ? null : $data->kota_saat_ini}}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Kodepos Saat Ini</label>
                    <input type="text" class="form-control" name="kodepos_saat_ini" placeholder="Kodepos Saat Ini" value="{{$data == null ? null : $data->kodepos_saat_ini}}" required>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Pendidikan Terakhir</label>
                    <select class="form-control" required name="pendidikan_terakhir">
                        <option value="">-pilih-</option>
                        <option value="SMA" {{$data->pendidikan_terakhir == 'SMA' ? 'selected':''}}>SMA/sederajat</option>
                        <option value="D3" {{$data->pendidikan_terakhir == 'D3' ? 'selected':''}}>D3</option>
                        <option value="S1" {{$data->pendidikan_terakhir == 'S1' ? 'selected':''}}>S1</option>
                        <option value="S2" {{$data->pendidikan_terakhir == 'S2' ? 'selected':''}}>S2</option>
                        <option value="S3" {{$data->pendidikan_terakhir == 'S3' ? 'selected':''}}>S3</option>
                    </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Nama SMA/Akademik/Universitas</label>
                    <input type="text" class="form-control" name="akademik" placeholder="Nama Akademik / Universitas" value="{{$data == null ? null : $data->akademik}}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Jurusan/Prodi</label>
                    <input type="text" class="form-control" name="jurusan" placeholder="Jurusan" value="{{$data == null ? null : $data->jurusan}}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">IPK (tidak wajib bagi sma/sederajat)</label>
                    <input type="text" class="form-control" name="ipk" placeholder="IPK" value="{{$data == null ? null : $data->ipk}}">
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">Pekerjaan Sekarang</label>
                    <input type="text" class="form-control" name="pekerjaan" placeholder="pekerjaan" value="{{$data == null ? null : $data->pekerjaan}}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">@ Akun Facebook (optional)</label>
                    <input type="text" class="form-control" name="facebook" placeholder="facebook" value="{{$data == null ? null : $data->facebook}}">
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">@ Akun Instagram (optional)</label>
                    <input type="text" class="form-control" name="instagram" placeholder="instagram" value="{{$data == null ? null : $data->instagram}}">
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                    <label class="form-label">@ Akun Tiktok (optional)</label>
                    <input type="text" class="form-control" name="tiktok" placeholder="tiktok" value="{{$data == null ? null : $data->tiktok}}">
                    </div>
                </div>
                </div>

        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
    </form>
  </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

@endpush