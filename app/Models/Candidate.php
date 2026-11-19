<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    public const STATUSES = [
        'submitted' => 'Diajukan',
        'reviewed'  => 'Direview',
        'accepted'  => 'Diterima',
        'rejected'  => 'Ditolak',
    ];

    protected $fillable = [
        'registration_code',
        'name',
        'position',
        'unit_region',
        'status',
        'notes',
    ];
}