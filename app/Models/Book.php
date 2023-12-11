<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author'];

    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    public function scopePopular(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query
            ->withCount([
                'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
            ])
            ->orderBy('reviews_count', 'DESC');
    }

    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query
            ->withAvg([
                'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
            ], 'rating')
            ->orderBy('reviews_avg_rating', 'DESC');
    }

    public function scopeMinReviews(Builder $query, int $min): Builder|QueryBuilder
    {
        return $query->having('reviews_count', '>=', $min);
    }

    private function dateRangeFilter(Builder $query, $from = null, $to = null): void
    {
        if ($from && !$to) {
            $query->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    }
}
