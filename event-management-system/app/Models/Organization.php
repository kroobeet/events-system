<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'legal_address', 'email'];
    private mixed $name;

    public function representatives(): HasMany
    {
        return $this->hasMany(Representative::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function getOrganizationNameAttribute(): string
    {
        return $this->name;
    }
}
