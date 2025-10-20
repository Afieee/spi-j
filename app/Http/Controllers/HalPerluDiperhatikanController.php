<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\HalPerluDiperhatikanTable;
use Illuminate\Support\Facades\DB;
use App\Models\Notice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Enums\Akibat;

class HalPerluDiperhatikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(HalPerluDiperhatikanTable $dataTable, $auditId)
    {
        return $dataTable->render('Dashboard.Hal-Diperhatikan.hal-hal', ['auditId' => $auditId]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($auditId)
    {
        return view('Dashboard.Hal-Diperhatikan.form-hal-hal', [
            'auditId' => $auditId,
            'akibat' => Akibat::asOptions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $auditId): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'consequence' => 'required|string',
            'description' => 'required|string',
        ], [
            'title.required' => 'Hal Yang Perlu Diperhatikan harus diisi!',
            'consequence.required' => 'Akibat harus diisi!',
            'description.required' => 'Keterangan harus diisi!',
        ]);

        DB::beginTransaction();
        try {

            Notice::create([
                'audit_id' => $auditId,
                'title' => $request->title,
                'consequence' => $request->consequence,
                'description' => $request->description,
            ]);
            DB::commit();
            return redirect()->route('audit.notice.index', $auditId)->with('success', 'Successfully Added Data!');
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
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $auditId, string $id)
    {
        return view('Dashboard.Hal-Diperhatikan.form-hal-hal', [
            'data' => Notice::find($id),
            'auditId' => $auditId,
            'akibat' => Akibat::asOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $auditId, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'consequence' => 'required|string',
            'description' => 'required|string',
        ], [
            'title.required' => 'Hal Yang Perlu Diperhatikan harus diisi!',
            'consequence.required' => 'Akibat harus diisi!',
            'description.required' => 'Keterangan harus diisi!',
        ]);

        DB::beginTransaction();
        try {
            Notice::where('id', $id)->update([
                'audit_id' => $auditId,
                'title' => $request->title,
                'consequence' => $request->consequence,
                'description' => $request->description,
            ]);
            DB::commit();
            return redirect()->route('audit.notice.index', $auditId)->with('success', 'Successfully update Data!');
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
        $data = Notice::find($request->dataId);
        try {
            $data->delete();

            return response()->json(['status' => true, 'message' => 'delete data successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'delete data failed'], 400);
        }
    }
}
