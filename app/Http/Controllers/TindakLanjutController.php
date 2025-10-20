<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Audit;
use App\Models\Recomended;
use App\Models\TindakLanjut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\TindakLanjutTable;

class TindakLanjutController extends Controller
{
    public function index($rekomendasiId)
    {

        // Ambil semua temuan berdasarkan id_audit
        $tindak_lanjut = TindakLanjut::where('id_recomendeds', $rekomendasiId)->paginate(5);
        // $rekomended = Recomended::where("id",)->get();
        $rekomendasi = Recomended::find($rekomendasiId);
        // dd($rekomendasiId);

        // Kirim ke view
        return view('Tindak-Lanjut.tindak-lanjut', ['tindakLanjuts' => $tindak_lanjut, 'id_recomendeds' => $rekomendasiId, 'title' => $rekomendasi->title]);
    }

    public function show($recomendedId)
    {
        // $data = Audit::where('id', $recomendedId)->with('findings', 'recomended')->first();
        $data = Recomended::where('id', $recomendedId)->with('audit', 'audit.findings')->first();
        return response()->json(['data' => $data, 'statusData' => Status::asOptions()], 200);
    }

    public function update(Request $request, $recomendedId)
    {
        DB::beginTransaction();
        try {
            $dataUpdate = ['status' => $request->status];
            if ($request->file('file_dinas')) {
                $dataUpdate['closed_file_surat'] = $request->file('file_dinas')->store('uploads', 'public');
            }
            // Audit::where('id', $recomendedId)->update($dataUpdate);
            Recomended::where('id', $recomendedId)->update($dataUpdate);
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Update status successfully'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function tampilTL()
    {
        $tindakLanjuts = TindakLanjut::orderBy('batas_waktu', 'asc')->paginate(10);

        return view('Tindak-Lanjut.tampil-tl', compact('tindakLanjuts'));
    }

    public function create($id)
    {
        $recomended = Recomended::findOrFail($id);
        $tindakLanjuts = TindakLanjut::where('id_recomendeds', $id)->paginate(2);
        $title = Recomended::find($id);

        return view('Tindak-Lanjut.tindak-lanjut', [
            'recomended' => $recomended,
            'tindakLanjuts' => $tindakLanjuts,
            'title' => $title->title,
]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_recomendeds' => 'required|exists:recomendeds,id',
            'catatan_tl' => 'required|string',
            'status_tl' => 'required|string',
            'batas_waktu' => 'required|date',
        ]);

        TindakLanjut::create([
            'id_recomendeds' => $request->id_recomendeds,
            'catatan_tl' => $request->catatan_tl,
            'status_tl' => $request->status_tl,
            'batas_waktu' => $request->batas_waktu,
        ]);

        return back()->with('success', 'Tindak lanjut berhasil ditambahkan.');
    }
}
