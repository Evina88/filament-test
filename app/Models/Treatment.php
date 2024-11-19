<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Treatment extends Model
{
    protected $casts = [
    'price' => MoneyCast::class,
    ];
    protected $fillable = ['description', 'notes', 'price'];

    public function patient(): BelongsTo
    {
            return $this->belongsTo(Patient::class);
    }
}
