<?php

namespace App\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Builder approved(bool $isApproved = true)
 * @method static Builder inApproved()
 */
trait HasApprovedScope
{
    /**
     * Scoping Model Queries to Approved / Not Approved Records using `is_approved` attribute.
     *
     * @param Builder $query
     * @param bool $isApproved
     * @return Builder
     */
    public function scopeApproved(Builder $query, bool $isApproved = true): Builder
    {
        return $query->where('is_approved', $isApproved);
    }

    /**
     * Scoping Model Queries to Not Approved Records using `is_approved` attribute.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeInApproved(Builder $query): Builder
    {
        return $this->approved(isApproved: false);
    }

    /**
     * Check if Model is Approved
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return (bool)$this->getAttribute('is_approved');
    }
}
