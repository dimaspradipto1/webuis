<?php

namespace App\Models\Concerns;

use App\Support\VirtualSlug;

trait HasVirtualSlug
{
    /**
     * Get the value of the model's route key (virtual slug + signed ID token).
     */
    public function getRouteKey(): mixed
    {
        if ($this->getKey()) {
            return VirtualSlug::forModel($this);
        }

        return parent::getRouteKey();
    }

    /**
     * Retrieve the model for a bound value (decodes virtual slug token to ID without DB slug lookup).
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if ($field !== null && $field !== $this->getKeyName() && $field !== 'slug') {
            return parent::resolveRouteBinding($value, $field);
        }

        $decodedId = VirtualSlug::decode($value);
        if ($decodedId !== null) {
            return $this->where($this->getKeyName(), $decodedId)->first();
        }

        return parent::resolveRouteBinding($value, $field);
    }

    /**
     * Dynamically compute the slug attribute in memory so no database slug column is needed.
     */
    public function getSlugAttribute($value): string
    {
        if ($this->getKey()) {
            return VirtualSlug::forModel($this);
        }

        return (string) ($value ?? '');
    }
}

