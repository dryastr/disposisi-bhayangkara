<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisi';

    protected $fillable = [
        'no_surat',
        'perihal_surat',
        'pengirim',
        'tanggal_surat_dibuat',
        'tanggal_surat_diterima',
        'file_name_surat',
        'source',
        'size',
        'ext',
        'status',
        'created_by',
        'updated_by',
        'user_id',
        'is_user',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'pivot_disposisi', 'disposisi_id', 'user_id');
    }
}
