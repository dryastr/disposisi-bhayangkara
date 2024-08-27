<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpriController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role->name === 'spri') {
            $countDiterima = Disposisi::where('status', 'diterima')
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->count();

            $countDitolak = Disposisi::where('status', 'ditolak')
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->count();

            $countPending = Disposisi::where('status', 'pending')
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->count();

            $months = range(1, 12);
            $diterimaData = $this->getMonthlyData('diterima', $user->id);
            $ditolakData = $this->getMonthlyData('ditolak', $user->id);
            $pendingData = $this->getMonthlyData('pending', $user->id);
        } else {
            $countDiterima = 0;
            $countDitolak = 0;
            $countPending = 0;
            $months = [];
            $diterimaData = [];
            $ditolakData = [];
            $pendingData = [];
        }

        return view('admin.spri.dashboard', compact('countDiterima', 'countDitolak', 'countPending', 'months', 'diterimaData', 'ditolakData', 'pendingData'));
    }

    private function getMonthlyData($status, $userId)
    {
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[$i] = Disposisi::where('status', $status)
                ->whereMonth('created_at', $i)
                ->whereHas('users', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })->count();
        }
        return $data;
    }
}
