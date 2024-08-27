<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LembarDisposisiUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role->name === 'user') {
            $disposisi = Disposisi::whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        } else {
            $disposisi = collect([]);
        }

        return view('user.lembar-disposisi.index', compact('disposisi'));
    }

    public function show($id)
    {
        $user = Auth::user();

        $disposisi = Disposisi::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->findOrFail($id);

        $karumkit = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->get();

        return view('user.lembar-disposisi.show', compact('disposisi', 'karumkit'));
    }
}
