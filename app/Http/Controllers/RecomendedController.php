<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Audit;
use App\Models\Recomended;
use App\Models\Recomendeds;
use App\Models\Temuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\RecomendedTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class RecomendedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id_temuan)
    {
        // Ambil semua temuan berdasarkan id_audit
        $rekomendasi = Recomended::where('id_temuan', $id_temuan)->whereIn('status', [1, 2])->paginate(5);
        $temuanId = $id_temuan;
        $temuan = Temuan::find($id_temuan);

        // Kirim ke view
        return view('Dashboard.Rekomendasi.rekomendasi', ['rekomendasi' => $rekomendasi, 'id_temuan' => $temuanId, 'isi_temuan' => $temuan->isi_temuan]);
    }

    public function tampilTable(Request $request)
{
    $recomendeds = Recomended::with(['temuan.audit'])
        ->whereIn('status', [1, 2])
        ->when($request->divisi, function ($query, $divisi) {
            // filter berdasarkan divisi di tabel audit
            return $query->whereHas('temuan.audit', function ($q) use ($divisi) {
                $q->where('divisi', $divisi);
            });
        })
        ->paginate(5);

    // ambil daftar divisi unik dari tabel audit
    $divisiList = \App\Models\Audit::select('divisi')
        ->distinct()
        ->orderBy('divisi', 'asc')
        ->pluck('divisi');

    return view('Tindak-Lanjut.rekomendasi', [
        'recomendeds' => $recomendeds,
        'divisiList'  => $divisiList,
    ]);
}


    public function halamanUpdateRecomendeds($id)
    {
        $recomendeds = Recomended::findOrFail($id);
        return view('Tindak-Lanjut.ubah-status-tl', ['recomendeds' => $recomendeds]);
    }


    public function updateRecomendeds(Request $request, $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $recomendeds = Recomended::findOrFail($id);

        $recomendeds->update([
            'status' => $request->status,
        ]);


        return redirect()->to('rekomendasi')->with('success', 'Status Diubah');
    }

    public function create($auditId)
    {
        return view('Dashboard..Rekomendasi.form-rekomendasi', [
            'auditId' => $auditId,
            'audit' => Audit::where('id', $auditId)->first(),
            'statuses' => Status::asOptions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'status' => 'required|string',
        'batas_waktu' => 'required|date',
        'pic' => 'required|string|max:255',
        'closed_file_surat' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048', // maksimal 2MB
        'id_temuan' => 'required|numeric',
    ], [
        'title.required' => 'Judul rekomendasi harus diisi!',
        'status.required' => 'Status harus diisi!',
        'batas_waktu.required' => 'Batas waktu harus diisi!',
        'pic.required' => 'PIC harus diisi!',
        'closed_file_surat.mimes' => 'File harus berupa PDF, DOC, DOCX, PNG, atau JPG!',
        'closed_file_surat.max' => 'Ukuran file maksimal 2 MB!',
    ]);

    DB::beginTransaction();

    try {
        $fileName = null;

        // 🧩 Cek apakah ada file di upload
        if ($request->hasFile('closed_file_surat')) {
            $file = $request->file('closed_file_surat');

            // Buat nama file unik agar tidak tabrakan
            $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

            // Simpan ke storage: public/storage/audit/uploads
            $file->storeAs('public/audit/uploads', $fileName);
        }

        // 🧩 Simpan ke database
        Recomended::create([
            'id_temuan' => $request->id_temuan,
            'title' => $request->title,
            'status' => $request->status,
            'batas_waktu' => $request->batas_waktu,
            'pic' => $request->pic,
            'closed_file_surat' => $fileName,
        ]);

        DB::commit();

        return redirect()->back()->with('success', 'Data rekomendasi berhasil disimpan!');
    } catch (\Throwable $th) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $th->getMessage());
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $auditId, string $id)
    {
        return view('Dashboard..Rekomendasi.form-rekomendasi', [
            'data' => Recomended::find($id),
            'auditId' => $auditId,
            'audit' => Audit::where('id', $auditId)->first(),
            'statuses' => Status::asOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $auditId, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'status' => 'required|string',
        ], [
            'title.required' => 'Rekomendasi harus diisi!',
            'status.required' => 'Status harus diisi!',
        ]);

        DB::beginTransaction();
        try {
            Recomended::where('id', $id)->update([
                'audit_id' => $auditId,
                'title' => $request->title,
                'status' => $request->status,
            ]);
            DB::commit();
            return redirect()->route('audit.rekomendasi.index', $auditId)->with('success', 'Successfully update Data!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to update Data!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = Recomended::find($request->dataId);
        try {
            $data->delete();

            return response()->json(['status' => true, 'message' => 'delete data successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'delete data failed'], 400);
        }
    }
}
