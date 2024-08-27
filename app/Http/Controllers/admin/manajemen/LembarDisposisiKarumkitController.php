<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Mail\DisposisiReceivedUser;
use App\Mail\DisposisiSent;
use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LembarDisposisiKarumkitController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role->name === 'karumkit') {
            $disposisiNullIsUser = Disposisi::whereNull('is_user')
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->get();

            $disposisiIsUser = Disposisi::where('is_user', 1)
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->get();
        } else {
            $disposisiNullIsUser = collect([]);
            $disposisiIsUser = collect([]);
        }

        return view('admin.karumkit.lembar-disposisi.index', compact('disposisiNullIsUser', 'disposisiIsUser'));
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

        return view('admin.karumkit.lembar-disposisi.show', compact('disposisi', 'karumkit'));
    }

    public function kirim(Request $request, $id)
    {
        $disposisi = Disposisi::findOrFail($id);

        $karumkitIds = $request->input('karumkit_id', []);
        $karumkits = User::whereIn('id', $karumkitIds)->get();

        DB::transaction(function () use ($disposisi, $karumkits) {
            foreach ($karumkits as $karumkit) {
                DB::table('pivot_disposisi')->insert([
                    'disposisi_id' => $disposisi->id,
                    'user_id' => $karumkit->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $disposisi->is_user = 1;
            $disposisi->save();

            $adminSpriUsers = User::whereHas('role', function ($query) {
                $query->whereIn('name', ['admin', 'spri']);
            })->get();

            foreach ($adminSpriUsers as $adminSpriUser) {
                Mail::to($adminSpriUser->email)->send(new DisposisiSent($disposisi, $karumkits));
            }

            foreach ($karumkits as $karumkit) {
                if ($karumkit->email) {
                    Mail::to($karumkit->email)->send(new DisposisiReceivedUser($disposisi, $karumkit));
                }
            }
        });

        return redirect()->route('lembar-disposisi-karumkit.index')->with('success', 'Disposisi telah dikirim dan email telah dikirim ke admin, spri, dan penerima disposisi yang dipilih.');
    }
}
