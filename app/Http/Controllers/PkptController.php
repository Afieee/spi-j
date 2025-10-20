<?php

namespace App\Http\Controllers;

use App\Models\Pkpt;
use Illuminate\Http\Request;

class PkptController extends Controller
{
    public function halamanTampilPKPT(Request $request)
    {
        $tahun = $request->input('tahun', date('Y')); // Default tahun saat ini jika tidak dipilih
        $pkpt = Pkpt::whereYear('created_at', $tahun)->paginate(3);

        return view('pkpt.halaman-pkpt', compact('pkpt', 'tahun'));
    }



    public function isiPKPT(Request $request)
    {
        $request->validate([
            'nama_penugasan' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:2048' // Hanya menerima file PDF max 2MB
        ]);

        // Simpan file ke storage/audit/uploads dengan nama asli
        $fileName = time() . '-' . $request->file('file')->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('audit/uploads', $fileName, 'public');

        // Simpan ke database
        Pkpt::create([
            'nama_penugasan_pkpt' => $request->nama_penugasan,
            'file_pkpt' => $filePath
        ]);

        return redirect()->route('halaman-pkpt')->with('success', 'PKPT berhasil ditambahkan');
    }
}
