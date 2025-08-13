@extends('layouts.master')

@push('css')
    
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  
@endpush
@section('content')
  
<div class="col-12">
    <form class="card" id="myForm" onsubmit="return validateForm(event)" method="POST" action="/user/home/essay" enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <h3 class="card-title">
              Pilih Sektor Dan Esai
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
                <div class="col-sm-12 col-md-12">
                    <div class="mb-3">
                    <label class="form-label">SEKTOR</label>
                    <select class="form-control" name="sektor_id" required>
                        <option value="">-pilih-</option>
                        @foreach ($sektor as $item)
                            <option value="{{$item->id}}" {{$data->sektor_id == $item->id ? 'selected':''}}>{{$item->nama}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="mb-3">
                    <label class="form-label">RINGKASAN ESAI (maks 30 Kata)</label>
                    <input type="text" class="form-control" name="ringkasan" id="inputText" oninput="checkWordLimit()" value="{{$data->ringkasan}}" required>
                    <span id="wordCountMsg" style="color: red;"></span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="mb-3">
                    <label class="form-label">ESAI (Maks 1500 kata)</label>
                    
                    <textarea id="summernote" name="essay" oninput="checkWordTextarea()" required>{!!$data->essay!!}</textarea>
                    <span id="wordCountTxt" style="color: red;"></span>
                    </div>
                </div>
                
                </div>

        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary" id="submitButton">Update</button>
        </div>
    </form>
  </div>
@endsection

@push('js')

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 400,
            lineHeights: [],
            callbacks: {
                onKeydown: function(e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault(); 
                        document.execCommand('insertLineBreak');
                    }
                },
                onKeyup: function(e) {
                        checkWordText();
                }
            }
        });

        function checkWordText() {
                const maxWords = 1500;
                const content = $('#summernote').summernote('code').replace(/<\/?[^>]+(>|$)/g, ""); // Menghapus HTML tags
                const words = content.trim().split(/\s+/);
                const wordCountMsg = document.getElementById('wordCountTxt');
                const submitButton = document.getElementById('submitButton');
                
                if (words.length > maxWords) {
                    wordCountMsg.textContent = `Maksimal ${maxWords} kata saja.`;

                    document.getElementById("wordCountTxt").style.color = "red";
                    submitButton.disabled = true; // Nonaktifkan tombol submit
                } else {
                    wordCountMsg.textContent = `Jumlah kata: ${words.length}`;
                    document.getElementById("wordCountTxt").style.color = "green";
                    submitButton.disabled = false; // Aktifkan kembali jika di bawah batas
                }
            }
    });
  </script>

<script>
    function checkWordTextarea() {
        console.log('textarea')
            const input = document.getElementById('summernote');
            const maxWords = 1500;
            const words = input.value.trim().split(/\s+/);
            const wordCountMsg = document.getElementById('wordCountTxt');
            
            if (words.length > maxWords) {
                wordCountMsg.textContent = `Maksimal ${maxWords} kata saja.`;
                document.getElementById("wordCountTxt").style.color = "red";
            } else {
                wordCountMsg.textContent = `Jumlah kata: ${words.length}`;
                document.getElementById("wordCountTxt").style.color = "green";
            }
        }

    function checkWordLimit() {
            const input = document.getElementById('inputText');
            const maxWords = 30;
            const words = input.value.trim().split(/\s+/);
            const wordCountMsg = document.getElementById('wordCountMsg');
            
            if (words.length > maxWords) {
                wordCountMsg.textContent = `Maksimal ${maxWords} kata saja.`;
                document.getElementById("wordCountMsg").style.color = "red";
                submitButton.disabled = true; // Nonaktifkan tombol submit
            } else {
                wordCountMsg.textContent = `Jumlah kata: ${words.length}`;
                document.getElementById("wordCountMsg").style.color = "green";
                submitButton.disabled = false; // Aktifkan kembali jika di bawah batas
            }
        }

    function validateForm(event) {
        const input = document.getElementById('inputText').value.trim();
        const words = input.split(/\s+/);
        const maxWords = 30;

        if (words.length > maxWords) {
            document.getElementById('wordCountMsg').textContent = `Jumlah kata melebihi batas maksimal ${maxWords} kata!`;
            event.preventDefault(); // Mencegah form dari pengiriman
            return false;
        }

        document.getElementById('wordCountMsg').textContent = ''; // Bersihkan pesan kesalahan jika validasi sukses
        return true; // Izinkan form dikirim jika jumlah kata sesuai
    }
</script>
@endpush