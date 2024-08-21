<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Mail\DisposisiAccepted;
use App\Mail\DisposisiRejectedNotification;
use App\Models\Announcement;
use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LembarDisposisiSpriController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role->name === 'spri') {
            $disposisi = Disposisi::whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        } else {
            $disposisi = collect([]);
        }

        return view('admin.spri.lembar-disposisi.index', compact('disposisi'));
    }

    public function show($id)
    {
        $user = Auth::user();

        $disposisi = Disposisi::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->findOrFail($id);

        $karumkit = User::whereHas('role', function ($query) {
            $query->where('name', 'Karumkit');
        })->get();

        return view('admin.spri.lembar-disposisi.show', compact('disposisi', 'karumkit'));
    }

    public function terima(Request $request, $id)
    {
        $disposisi = Disposisi::findOrFail($id);

        $disposisi->status = 'diterima';
        $disposisi->save();

        $karumkitId = $request->input('karumkit_id');
        $karumkit = User::findOrFail($karumkitId);

        Mail::to($karumkit->email)->send(new DisposisiAccepted($disposisi, $karumkit));

        DB::table('pivot_disposisi')->insert([
            'disposisi_id' => $disposisi->id,
            'user_id' => $karumkit->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('lembar-disposisi.index')->with('success', 'Disposisi diterima dan email telah dikirim.');
    }

    public function tolak(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string',
        ]);

        $disposisi = Disposisi::findOrFail($id);

        $disposisi->status = 'ditolak';
        $disposisi->keterangan = $request->input('keterangan');
        $disposisi->save();

        $lastUpdatedById = $disposisi->updated_by;
        $lastUpdatedBy = User::find($lastUpdatedById);

        if ($lastUpdatedBy) {
            Mail::to($lastUpdatedBy->email)->send(new DisposisiRejectedNotification($disposisi, $lastUpdatedBy));

            Announcement::create([
                'title' => 'Lembar Disposisi Telah Ditolak',
                'is_read' => false,
                'disposisi_id' => $disposisi->id,
                'user_id' => $lastUpdatedById,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);
        } else {
        }

        return redirect()->route('lembar-disposisi.index')->with('success', 'Disposisi ditolak.');
    }
}
