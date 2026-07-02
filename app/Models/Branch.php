<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'code',
        'address',
    ];

    // Tambahkan relasi ini agar Branch tahu dia milik Company yang mana
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
