<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $total = Pengaduan::count();
        $diproses = Pengaduan::where('status', 1)->count();
        $selesai = Pengaduan::where('status', 2)->count();
        $ditolak = Pengaduan::where('status', 3)->count();
        $dataPoints = [
            ['label' => 'Ditolak', 'y' => $ditolak],
            ['label' => 'Selesai', 'y' => $selesai],
            ['label' => 'Diproses', 'y' => $diproses],
            ['label' => 'Total Pengaduan', 'y' => $total]
        ];
        return view('home', compact('dataPoints'));
    }
}
