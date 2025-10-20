<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\LaporanTable;
use App\Http\Requests\AuditRequest;
use Illuminate\Support\Facades\DB;
use App\Models\ReportActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{

    public function __construct() {}

    /**
     * Display a listing of the resource.
     */
    public function index(LaporanTable $dataTable)
    {
        return $dataTable->render('Laporan.laporan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Laporan.form-laporan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomorLaporan' => 'required|unique:report_activities,code',
            'tanggal' => 'required|date',
            'judul' => 'required|string',
            'divisi' => 'required|string',
            'attachment' => 'required|file|mimes:pdf,png,jpg,jpeg',
        ]);

        DB::beginTransaction();
        try {

            $attachment = $request->file('attachment')->store('uploads', 'public');

            ReportActivity::create([
                'code' => $request->nomorLaporan,
                'date' => $request->tanggal,
                'divisi' => $request->divisi,
                'description' => $request->description,
                'attachment' => $attachment,
            ]);
            DB::commit();
            return redirect()->route('laporan.index')->with('success', 'Successfully Added Data!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = ReportActivity::find($id);
        return response()->json(['data' => $data], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = ReportActivity::find($id);
        return view('Laporan.form-laporan', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nomorLaporan' => 'required|unique:report_activities,code,' . $id,
            'tanggal' => 'required|date',
            'judul' => 'required|string',
            'divisi' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,png,jpg,jpeg',
        ]);

        DB::beginTransaction();
        try {
            $dataOld = ReportActivity::find($id);

            $dataUpdate = [
                'code' => $request->nomorLaporan,
                'date' => $request->tanggal,
                'divisi' => $request->divisi,
                'title' => $request->judul,
                'description' => $request->description,
            ];

            if ($request->file('attachment')) {
                Storage::delete($dataOld->attachment);
                $dataUpdate['attachment'] = $request->file('attachment')->store('uploads', 'public');
            }

            ReportActivity::where('id', $id)->update($dataUpdate);
            DB::commit();
            return redirect()->route('laporan.index')->with('success', 'Successfully update Data!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = ReportActivity::find($request->dataId);
        try {
            Storage::delete($data->attachment);
            $data->delete();

            return response()->json(['status' => true, 'message' => 'delete data successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'delete data failed'], 400);
        }
    }
}
