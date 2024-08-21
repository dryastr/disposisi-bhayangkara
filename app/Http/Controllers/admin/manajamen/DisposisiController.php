<?php

namespace App\Http\Controllers\admin\manajamen;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use App\Models\User;
use App\Mail\DisposisiNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DisposisiController extends Controller
{
    public function index()
    {
        $disposisi = Disposisi::all();
        return view('admin.admin.disposisi.index', compact('disposisi'));
    }

    public function show(Disposisi $disposisi)
    {
        $user = $disposisi->user;
        return view('admin.admin.disposisi.show', compact('disposisi', 'user'));
    }

    public function create()
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'spri');
        })->get();

        return view('admin.admin.disposisi.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_surat' => 'required|string|max:50',
            'perihal_surat' => 'required|string',
            'pengirim' => 'required|string|max:100',
            'tanggal_surat_dibuat' => 'required|date',
            'tanggal_surat_diterima' => 'required|date',
            'file' => 'required|file|mimes:pdf|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);

        $file = $request->file('file');
        $fileName = time() . '-' . $file->getClientOriginalName();
        $filePath = $file->storeAs('public/disposisi', $fileName);

        $disposisi = Disposisi::create([
            'no_surat' => $request->no_surat,
            'perihal_surat' => $request->perihal_surat,
            'pengirim' => $request->pengirim,
            'tanggal_surat_dibuat' => $request->tanggal_surat_dibuat,
            'tanggal_surat_diterima' => $request->tanggal_surat_diterima,
            'file_name_surat' => $fileName,
            'source' => $filePath,
            'size' => $file->getSize(),
            'ext' => $file->getClientOriginalExtension(),
            'status' => 'pending',
            'keterangan' => null,
            'user_id' => $request->user_id,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        DB::table('pivot_disposisi')->insert([
            'disposisi_id' => $disposisi->id,
            'user_id' => $request->user_id,
        ]);

        $user = User::find($request->user_id);
        Mail::to($user->email)->send(new DisposisiNotification($disposisi, $user));

        return redirect()->route('disposisi.index')->with('success', 'Disposisi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $disposisi = Disposisi::findOrFail($id);
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'spri');
        })->get();

        return view('admin.admin.disposisi.edit', compact('disposisi', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_surat' => 'required|string|max:50',
            'perihal_surat' => 'required|string',
            'pengirim' => 'required|string|max:100',
            'tanggal_surat_dibuat' => 'required|date',
            'tanggal_surat_diterima' => 'required|date',
            'file' => 'nullable|file|mimes:pdf|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);

        $disposisi = Disposisi::findOrFail($id);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/disposisi', $fileName);

            if ($disposisi->file_name_surat) {
                Storage::delete('public/disposisi/' . $disposisi->file_name_surat);
            }

            $disposisi->file_name_surat = $fileName;
            $disposisi->source = $filePath;
            $disposisi->size = $file->getSize();
            $disposisi->ext = $file->getClientOriginalExtension();
        }

        $disposisi->no_surat = $request->no_surat;
        $disposisi->perihal_surat = $request->perihal_surat;
        $disposisi->pengirim = $request->pengirim;
        $disposisi->tanggal_surat_dibuat = $request->tanggal_surat_dibuat;
        $disposisi->tanggal_surat_diterima = $request->tanggal_surat_diterima;
        $disposisi->status = 'pending';
        $disposisi->keterangan = null;
        $disposisi->user_id = $request->user_id;
        $disposisi->updated_by = auth()->id();
        $disposisi->save();

        DB::table('pivot_disposisi')
            ->updateOrInsert(
                ['disposisi_id' => $disposisi->id],
                ['user_id' => $request->user_id]
            );

        return redirect()->route('disposisi.index')->with('success', 'Disposisi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $disposisi = Disposisi::findOrFail($id);
        Storage::delete($disposisi->source);
        $disposisi->delete();

        return redirect()->route('disposisi.index')->with('success', 'Data disposisi berhasil dihapus');
    }
}
