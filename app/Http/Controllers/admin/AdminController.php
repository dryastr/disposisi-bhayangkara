<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $countDiterima = Disposisi::where('status', 'diterima')->count();
        $countDitolak = Disposisi::where('status', 'ditolak')->count();
        $countPending = Disposisi::where('status', 'pending')->count();

        $disposisiByMonth = Disposisi::selectRaw('MONTH(created_at) as month, status, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month', 'status')
            ->get()
            ->groupBy('status');

        $months = range(1, 12);
        $diterimaData = array_fill(0, 12, 0);
        $ditolakData = array_fill(0, 12, 0);
        $pendingData = array_fill(0, 12, 0);

        foreach ($disposisiByMonth as $status => $data) {
            foreach ($data as $item) {
                if ($status == 'diterima') {
                    $diterimaData[$item->month - 1] = $item->count;
                } elseif ($status == 'ditolak') {
                    $ditolakData[$item->month - 1] = $item->count;
                } elseif ($status == 'pending') {
                    $pendingData[$item->month - 1] = $item->count;
                }
            }
        }

        return view('admin.admin.dashboard', compact('countDiterima', 'countDitolak', 'countPending', 'months', 'diterimaData', 'ditolakData', 'pendingData'));
    }


}
