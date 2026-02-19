<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\Http\Request;

class HistoryAuditController extends Controller
{
    public function historyAudit()
    {
        Audit::all();
        return view('HistoryAudit.history-audit', [
            'audits' => Audit::all(),
        ]);
    }
}
