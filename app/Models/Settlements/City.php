<?php

declare(strict_types=1);

namespace App\Models\Settlements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
