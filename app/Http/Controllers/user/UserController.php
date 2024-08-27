<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role->name === 'user') {
            $disposisiCount = Disposisi::whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count();

            $disposisi = Disposisi::whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();

            $months = range(1, 12);
            $acceptedData = $this->getMonthlyData('diterima', $user->id);
            $rejectedData = $this->getMonthlyData('ditolak', $user->id);
            $pendingData = $this->getMonthlyData('pending', $user->id);
        } else {
            $disposisiCount = 0;
            $disposisi = collect([]);
            $months = [];
            $acceptedData = [];
            $rejectedData = [];
            $pendingData = [];
        }

        return view('user.dashboard', compact('disposisi', 'disposisiCount', 'months', 'acceptedData', 'rejectedData', 'pendingData'));
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
