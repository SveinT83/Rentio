<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Postnummerregister extends Model
{
    protected $table = 'postnummerregister';

    public $timestamps = false;

    protected $fillable = [
        'Postnummer',
        'Poststed',
        'Kommunenummer',
        'Kommunenavn',
    ];

    public function casts(): array
    {
        return [
            'Postnummer' => 'string',
            'Poststed' => 'string',
            'Kommunenummer' => 'string',
            'Kommunenavn' => 'string',
        ];
    }

    public function scopeByPostnummer(Builder $query, string|int $postnummer): Builder
    {
        return $query->where('Postnummer', (string) $postnummer);
    }

    public function scopeByKommunenummer(Builder $query, string $kommunenummer): Builder
    {
        return $query->where('Kommunenummer', $kommunenummer);
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where(function (Builder $q) use ($term): void {
            $q->where('Poststed', 'like', "%{$term}%")
                ->orWhere('Kommunenavn', 'like', "%{$term}%");
        });
    }
}
