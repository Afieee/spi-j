<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\LaporanHasilAuditTable;
use App\Http\Requests\AuditRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Audit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class LaporanHasilAuditController extends Controller
{

    public function __construct() {}


    public function index(LaporanHasilAuditTable $dataTable)
    {
        return $dataTable->render('Dashboard.laporan-hasil-audit');
    }




    public function create()
    {
        return view('Dashboard.form-hasil-audit');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomorLaporan' => 'required|unique:audits,code',
            'judul_audit' => 'required|string',
            'tanggal' => 'required|date',
            'divisi' => 'required|string',
            'surat_tugas' => 'required|file|mimes:pdf',
            'nota_dinas' => 'required|file|mimes:pdf',
            'bentuk_kegiatan' => 'nullable|string',
            'berita_acara_exit_meeting' => 'required|file|mimes:pdf',
            'laporan_dan_lampiran' => 'required|file|mimes:pdf',
            'anggota' => 'nullable|array',
            'anggota.*.anggota' => 'nullable|string',
            'pka' => 'required|file|mimes:pdf'
        ]);

        DB::beginTransaction();
        try {
            Storage::makeDirectory('public/audit/uploads');

            $member = array_filter(array_column($request->anggota ?? [], 'anggota'));

            $filePaths = [
                'file_surat_tugas' => $request->file('surat_tugas')->store('audit/uploads', 'public'),
                'file_nota_dinas' => $request->file('nota_dinas')->store('audit/uploads', 'public'),
                'berita_acara_exit_meeting' => $request->file('berita_acara_exit_meeting')->store('audit/uploads', 'public'),
                'laporan_dan_lampiran' => $request->file('laporan_dan_lampiran')->store('audit/uploads', 'public'),
                'pka' => $request->file('pka')->store('audit/uploads', 'public'),
            ];



            Audit::create([
                'code' => $request->nomorLaporan,
                'judul_audit' => $request->judul_audit,
                'date' => $request->tanggal,
                'divisi' => $request->divisi,
                'activity' => $request->bentuk_kegiatan,
                'member' => $member ? json_encode($member) : null,
            ] + $filePaths);

            DB::commit();
            return redirect()->route('audit.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function halamanIsiPKPT()
    {
        $data = Audit::paginate(5);
        return view('Dashboard.halaman-isi-pkpt', compact('data'));
    }



    public function uploadPka(Request $request, $id)
    {
        $request->validate([
            'pka' => 'required|file|mimes:pdf',
        ]);

        $audit = Audit::findOrFail($id);
        $filePath = $request->file('pka')->store('audit/uploads', 'public');
        $audit->update(['pka' => $filePath]);

        return redirect()->back()->with('success', 'File PKPT berhasil diupload!');
    }




    public function show(string $id)
    {
        $data = Audit::find($id);
        return response()->json(['data' => $data], 200);
    }


    public function edit(string $id)
    {
        $data = Audit::find($id);
        return view('Dashboard.form-hasil-audit', compact('data'));
    }


    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nomorLaporan' => 'required|unique:audits,code,' . $id,
            'tanggal' => 'required|date',
            'divisi' => 'required|string',
            'surat_tugas' => 'nullable|file|mimes:pdf',
            'nota_dinas' => 'nullable|file|mimes:pdf',
            'bentuk_kegiatan' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $dataOld = Audit::find($id);
            $member = [];
            if ($request->anggota) {
                foreach ($request->anggota as $key => $value) {
                    if ($value['anggota']) $member[] = $value['anggota'];
                }
            }

            $dataUpdate = [
                'code' => $request->nomorLaporan,
                'date' => $request->tanggal,
                'divisi' => $request->divisi,
                'activity' => $request->bentuk_kegiatan,
                'member' => !$member ? NULL : json_encode($member),
            ];

            if ($request->file('surat_tugas')) {
                Storage::delete($dataOld->file_surat_tugas);
                $dataUpdate['file_surat_tugas'] = $request->file('surat_tugas')->store('uploads', 'public');
            }

            if ($request->file('nota_dinas')) {
                Storage::delete($dataOld->file_nota_dinas);
                $dataUpdate['file_nota_dinas'] = $request->file('nota_dinas')->store('uploads', 'public');
            }

            Audit::where('id', $id)->update($dataUpdate);
            DB::commit();
            return redirect()->route('audit.index')->with('success', 'Successfully update Data!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function destroy(Request $request)
    {
        $data = Audit::find($request->dataId);
        try {
            Storage::delete($data->file_surat_tugas);
            Storage::delete($data->file_nota_dinas);
            $data->delete();

            return response()->json(['status' => true, 'message' => 'delete data successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'delete data failed'], 400);
        }
    }
}
