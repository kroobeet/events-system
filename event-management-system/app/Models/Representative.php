<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Representative extends Model
{
    use HasFactory;

    protected $fillable = ['organization_id', 'last_name', 'first_name', 'patronymic', 'phone', 'departament'];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->patronymic;
    }
}
