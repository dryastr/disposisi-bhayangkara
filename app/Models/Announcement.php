<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_read',
        'disposisi_id',
        'user_id',
        'created_by',
        'updated_by',
    ];

    public function disposisi()
    {
        return $this->belongsTo(Disposisi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
