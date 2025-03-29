<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memory extends Model
{
    use HasFactory;

    protected $fillable = [
        'imageName',
        'invitation_id'
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
} 