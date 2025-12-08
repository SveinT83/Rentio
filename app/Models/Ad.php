<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ad extends Model
{
    protected $table = 'ads';

    protected $fillable = [
        'user_id',
        'ad_name',
        'price',
        'price_period',
        'description',
        'category_id',
        'subcategory_id',
        'location',
        'municipality',
        'images',
        'is_active',
        'is_available',
    ];

    public function views(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\AdView::class);
    }

    public function scopeWithRecentViewsCount($query, int $days = 7)
    {
        return $query->withCount(['views as recent_views_count' => function ($q) use ($days): void {
            $q->where('view_date', '>=', now()->subDays($days)->toDateString());
        }]);
    }

    public function casts(): array
    {
        return [
            'price' => 'integer',
            'images' => 'array',
            'is_active' => 'boolean',
            'is_available' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AdCategory::class, 'category_id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(AdCategory::class, 'subcategory_id');
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }
}
