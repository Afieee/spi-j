<?php

namespace App\Http\Controllers;

use App\Enums\Akibat;
use App\Models\Audit;
use App\Models\Temuan;
use App\Models\Finding;
use App\Enums\JenisTemuan;
use Illuminate\Http\Request;
use App\DataTables\TemuanTable;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class TemuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($auditId)
    {
        // Ambil semua temuan berdasarkan id_audit
        $temuan = Temuan::where('id_audit', $auditId)->paginate(5);
        $id_audit = $auditId;
        $audit = Audit::find($auditId);

        // Kirim ke view
        return view('Dashboard.Temuan.temuan', ['temuan' => $temuan, 'id_audit' => $id_audit, 'judul_audit' => $audit->judul_audit]);
    }


    public function tampilTable(Request $request)
    {
        $recomendeds = Temuan::with('audit')->paginate(5);


        return view('Tindak-Lanjut.rekomendasi', [
            'recomendeds' => $recomendeds,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($auditId)
    {
        return view('Dashboard.Temuan.tambah-temuan', [
            'auditId' => $auditId,
            'jenisTemuan' => JenisTemuan::asOptions(),
            'akibat' => Akibat::asOptions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'isi_temuan' => 'required|string',
        'jenis_temuan' => 'required|string',
        'akibat' => 'required|string',
        'id_audit' => 'required|numeric',
    ], [
        'isi_temuan.required' => 'Isi Temuan harus diisi!',
        'jenis_temuan.required' => 'Jenis Temuan harus diisi!',
        'akibat.required' => 'Akibat harus diisi!',
    ]);

    Temuan::create([
        'id_audit' => $request->id_audit,
        'isi_temuan' => $request->isi_temuan,
        'jenis_temuan' => $request->jenis_temuan,
        'akibat' => $request->akibat,
    ]);

    return redirect()->back()->with('success', 'Data temuan berhasil disimpan!');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Finding::find($id);
        $response = [];
        if ($data) {
            $response = [
                'id' => $data->id,
                'title' => $data->title,
                'consequence' => Akibat::getDescription($data->consequence),
                'typeFinding' => JenisTemuan::getDescription($data->type_finding),
                'markFinding' => $data->mark_finding,
                'reasons' => $data->reason,
                'criterias' => $data->criteria,
            ];
        }
        return response()->json(['data' => $response], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $auditId, string $id)
    {
        return view('Dashboard.Temuan.form-temuan', [
            'data' => Finding::find($id),
            'auditId' => $auditId,
            'jenisTemuan' => JenisTemuan::asOptions(),
            'akibat' => Akibat::asOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $auditId, string $id)
    {
        $validated = $request->validate([
            'temuan' => 'required|string',
            'type_finding' => ['required', 'string'],
            'consequence' => 'required|string',
            'mark_finding' => $request->type_finding == '1' ? 'required|numeric' : '',
        ], [
            'temuan.required' => 'Temuan harus diisi!',
            'type_finding.required' => 'Jenis Temuan harus diisi!',
            'consequence.required' => 'Akibat harus diisi!',
            'mark_finding.required' => 'Nilai Temuan harus diisi!',
            'mark_finding.numeric' => 'Nilai Temuan harus angka!',
        ]);

        DB::beginTransaction();
        try {
            $reasons = [];
            if ($request->reason) {
                foreach ($request->reason as $key => $value) {
                    if ($value['reason']) $reasons[] = $value['reason'];
                }
            }

            $criterias = [];
            if ($request->criteria) {
                foreach ($request->criteria as $key => $value) {
                    if ($value['criteria']) $criterias[] = $value['criteria'];
                }
            }

            Finding::where('id', $id)->update([
                'audit_id' => $auditId,
                'title' => $request->temuan,
                'consequence' => $request->consequence,
                'type_finding' => $request->type_finding,
                'mark_finding' => $request->mark_finding,
                'reason' => !$reasons ? NULL : json_encode($reasons),
                'criteria' => !$criterias > 0 ? NULL : json_encode($criterias),
            ]);
            DB::commit();
            return redirect()->route('audit.temuan.index', $auditId)->with('success', 'Successfully update Data!');
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
        $data = Finding::find($request->dataId);
        try {
            $data->delete();

            return response()->json(['status' => true, 'message' => 'delete data successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'delete data failed'], 400);
        }
    }
}
