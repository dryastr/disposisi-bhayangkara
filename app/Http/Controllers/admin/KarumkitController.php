<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KarumkitController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role->name === 'karumkit') {
            $countNotSent = Disposisi::whereNull('is_user')
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->count();

            $countSent = Disposisi::where('is_user', 1)
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->count();

            $months = range(1, 12);
            $notSentData = $this->getMonthlyData(null, $user->id);
            $sentData = $this->getMonthlyData(1, $user->id);
        } else {
            $countNotSent = 0;
            $countSent = 0;
            $months = [];
            $notSentData = [];
            $sentData = [];
        }

        return view('admin.karumkit.dashboard', compact('countNotSent', 'countSent', 'months', 'notSentData', 'sentData'));
    }

    private function getMonthlyData($isUser, $userId)
    {
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $query = Disposisi::whereMonth('created_at', $i)
                ->whereHas('users', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                });

            if ($isUser !== null) {
                $query->where('is_user', $isUser);
            } else {
                $query->whereNull('is_user');
            }

            $data[$i] = $query->count();
        }
        return $data;
    }
}
