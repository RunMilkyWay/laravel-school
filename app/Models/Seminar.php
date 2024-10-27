<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Seminar extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'speakers',
        'location',
        'created_by',
        'status',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'registrations');
    }
}
