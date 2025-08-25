<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bidang;
use App\Models\Sektor;
use App\Models\Profile;
use App\Models\Setting;


use App\Models\Instagram;
use App\Models\Pengaduan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF as PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class SuperadminController extends Controller
{
    public function uploadFoto(Request $request, $id)
    {
        // Validasi file
        // dd($request->hasFile('files'), $request->files);
        // if ($request->hasFile('files')) {
        //     foreach ($request->file('files') as $file) {
        //         // Debug file
        //         dd($file->getClientOriginalName(), $file->getMimeType(), $file->getSize());
        //     }
        // } else {
        //     dd('No files uploaded.');
        // }

        $request->validate([
            'files.*' => 'required|file|mimes:jpg,png,jpeg|max:10240',
        ]);

        $uploadedFiles = $request->file('files');


        if ($uploadedFiles) {
            foreach ($uploadedFiles as $file) {
                $originalName = $file->getClientOriginalName();

                $filename = uniqid(Str::random(6)) . '.' . $file->getClientOriginalExtension();

                $file->move(public_path('storage') . '/instagram', $filename);

                $n = new Instagram();
                $n->profile_id = $id;
                $n->filename = $filename;
                $n->realname = $originalName;
                $n->save();
            }
        }

        return back()->with('success', 'Files uploaded successfully!');
    }
    public function home()
    {
        $data = Pengaduan::orderBy('id', 'desc')->paginate(10);
        return view('admin.home', compact('data'));
    }

    public function deleteFoto($id)
    {
        $ig = Instagram::find($id);
        $path = 'instagram/' . $ig->filename;

        Storage::disk('public')->delete($path);
        $ig->delete();
        return back();
    }
    public function tambahPengaduan()
    {
        return view('admin.pengaduan.create');
    }

    public function simpanPengaduan(Request $req)
    {
        $param = $req->all();
        $param['user_id'] = Auth::user()->id;
        Pengaduan::create($param);

        return redirect('/admin/home')->with('success', 'Aduan berhasil di dikirim');
    }
    public function deletePengaduan($id)
    {
        Pengaduan::find($id)->delete();
        return back()->with('success', 'berhasil dihapus');
    }
    public function prosesPengaduan($id)
    {
        Pengaduan::find($id)->update(['status' => 1]);
        return back()->with('success', 'berhasil di proses');
    }
    public function selesaiPengaduan($id)
    {
        Pengaduan::find($id)->update(['status' => 2]);
        return back()->with('success', 'berhasil di selesaikan');
    }

    public function tolakPengaduan($id)
    {
        Pengaduan::find($id)->update(['status' => 3]);
        return back()->with('success', 'berhasil di tolakkan');
    }
    public function lihatPengaduan($id)
    {
        $data = Pengaduan::find($id);
        return view('admin.pengaduan.lihat', compact('data'));
    }
    public function downloadFoto($id)
    {
        $ig = Instagram::find($id);
        $filePath = 'instagram/' . $ig->filename;

        // Cek apakah file ada
        if (Storage::disk('public')->exists($filePath)) {
            // Mengunduh file
            $realname = $ig->realname;
            return Storage::disk('public')->download($filePath, $realname);
        } else {
            return response()->json(['error' => 'File tidak ditemukan.'], 404);
        }
    }

    public function updateInstagram(Request $req, $id)
    {
        Profile::find($id)->update([
            'like' => $req->like,
            'comment' => $req->comment,
            'share' => $req->share,
        ]);

        return back()->with('success', 'berhasil');
    }
    public function filter()
    {
        $bidang_id = request()->get('bidang_id');
        $sektor_id = request()->get('sektor_id');
        $status = request()->get('status');
        $sektor = Sektor::get();
        $bidang = Bidang::get();

        if ($sektor_id === null && $status === null) {
            $data = Profile::orderBy('id', 'ASC')->get();
        } elseif ($sektor_id != null && $status === null) {
            $data = Profile::orderBy('id', 'ASC')->where('sektor_id', $sektor_id)->get();
        } elseif ($sektor_id === null && $status != null) {
            $data = Profile::where('status_kirim', $status)->orderBy('id', 'ASC')->get();
        } elseif ($sektor_id != null && $status != null) {
            $data = Profile::orderBy('id', 'ASC')->where('sektor_id', $sektor_id)->where('status_kirim', $status)->get();
        }

        request()->flash();
        return view('admin.home', compact('data', 'bidang', 'sektor'));
    }
    public function detailPendaftar($id)
    {
        $data = Profile::find($id);
        return view('admin.detail', compact('data'));
    }

    public function deletePendaftar($id)
    {
        $data = Profile::find($id);
        User::where('profile_id', $data->id)->first()->delete();
        $data->delete();
        return back()->with('success', 'berhasil di hapus');
    }
    public function validasi(Request $req)
    {

        $data = Profile::find($req->profile_id)->update([
            'status_kirim' => $req->status_kirim,
            'keterangan' => $req->keterangan
        ]);
        return back()->with('success', 'telah di validasi');
    }
    public function streamKTP($id)
    {
        Profile::find($id)->update(['preview_ktp' => 1]);
        $data = Profile::find($id);

        // Tentukan path ke file gambar
        $path = storage_path('app/public/ktp/' . $data->file_ktp);

        // Periksa apakah file ada
        if (!file_exists($path)) {
            abort(404); // Mengembalikan 404 jika file tidak ditemukan
        }

        // Kembalikan respons gambar
        return response()->file($path);
    }
    public function streamIJAZAH($id)
    {
        Profile::find($id)->update(['preview_ijazah' => 1]);
        $data = Profile::find($id);
        $path = storage_path('app/public/pdf/' . $data->file_ijazah);

        if (!file_exists($path)) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML('<h1>File Tidak Ada</h1>');
            return $pdf->stream();
        }
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $data->file_ijazah . '"',
        ]);
    }
    public function streamSERTIFIKAT($id)
    {
        Profile::find($id)->update(['preview_sertifikat' => 1]);
        $data = Profile::find($id);
        $path = storage_path('app/public/pdf/' . $data->file_sertifikat);

        if (!file_exists($path)) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML('<h1>File Tidak Ada</h1>');
            return $pdf->stream();
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $data->file_sertifikat . '"',
        ]);
    }
    public function streamPDF($id)
    {
        try {
            $data = Profile::find($id);

            $oMerger = PDFMerger::init();
            if ($data->file_ktp != null) {
                $pathKTP = public_path('storage') . '/pdf/' . $data->file_ktp;
            } else {
                $pathKTP = null;
            }
            if ($data->file_ijazah != null) {
                $pathIJAZAH = public_path('storage') . '/pdf/' . $data->file_ijazah;
            } else {
                $pathIJAZAH = null;
            }
            if ($data->file_sertifikat != null) {
                $pathSERTIFIKAT = public_path('storage') . '/pdf/' . $data->file_sertifikat;
            } else {
                $pathSERTIFIKAT = null;
            }

            $oMerger->addPDF($pathKTP);
            $oMerger->addPDF($pathIJAZAH);
            $oMerger->addPDF($pathSERTIFIKAT, 'all');


            $oMerger->merge();
            $oMerger->save('storage/merge/' . $data->id . '.pdf');

            $pathToFile = public_path() . '/storage/merge/' . $data->id . '.pdf';

            return response()->file($pathToFile);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function berkasPendaftar($id)
    {
        $data = Profile::find($id);
        return view('admin.detail', compact('data'));
    }

    public function setting()
    {
        $data = Setting::first();
        return view('admin.setting.index', compact('data'));
    }


    public function updateSetting(Request $req)
    {
        $data = Setting::first()->update([
            'is_aktif' => $req->is_aktif
        ]);
        return back()->with('success', 'berhasil');
    }
    public function bidang()
    {
        $data = Bidang::get();
        return view('admin.bidang.index', compact('data'));
    }
    public function add_bidang()
    {
        $sektor = Sektor::get();
        return view('admin.bidang.add', compact('sektor'));
    }
    public function store_bidang(Request $req)
    {
        Bidang::create($req->all());
        return redirect('/admin/bidang');
    }
    public function edit_bidang($id)
    {
        $data = Bidang::find($id);
        $sektor = Sektor::get();
        return view('admin.bidang.edit', compact('data', 'sektor'));
    }
    public function update_bidang(Request $req, $id)
    {
        Bidang::find($id)->update($req->all());
        return redirect('/admin/bidang');
    }
    public function delete_bidang($id)
    {
        $data = Bidang::find($id)->delete();
        return back();
    }


    public function sektor()
    {
        $data = Sektor::get();
        return view('admin.sektor.index', compact('data'));
    }
    public function add_sektor()
    {
        return view('admin.sektor.add');
    }
    public function store_sektor(Request $req)
    {
        $param = $req->all();
        $param['nama'] = strtoupper($req->nama);
        Sektor::create($param);
        return redirect('/admin/sektor');
    }
    public function edit_sektor($id)
    {
        $data = Sektor::find($id);
        return view('admin.sektor.edit', compact('data'));
    }
    public function update_sektor(Request $req, $id)
    {
        $param = $req->all();
        $param['nama'] = strtoupper($req->nama);
        Sektor::find($id)->update($param);
        return redirect('/admin/sektor');
    }
    public function delete_sektor($id)
    {
        $data = Sektor::find($id)->delete();
        return back();
    }
}
