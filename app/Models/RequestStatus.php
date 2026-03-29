<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestStatus extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'color',
        'icon',
        'order',
        'is_default',
        'column_classes',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get all client requests with this status
     */
    public function clientRequests()
    {
        return $this->hasMany(ClientRequest::class, 'status_id');
    }

    /**
     * Scope to order by the order column
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Scope to get only custom (non-default) statuses
     */
    public function scopeCustom($query)
    {
        return $query->where('is_default', false);
    }

    /**
     * Get the translated label for this status
     */
    public function label(): string
    {
        return __($this->name);
    }

    /**
     * Get the color for this status
     */
    public function color(): string
    {
        return $this->color;
    }

    /**
     * Get badge CSS classes based on color
     */
    public function badgeClasses(): string
    {
        return match ($this->color) {
            'gray' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
            'blue' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'green' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'red' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            'purple' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
            'pink' => 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200',
            'indigo' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
        };
    }

    /**
     * Get column CSS classes for kanban board
     */
    public function columnClasses(): string
    {
        return $this->column_classes ?? 'bg-gray-50 dark:bg-gray-800';
    }

    /**
     * Check if this status can be deleted
     */
    public function canDelete(): bool
    {
        // Cannot delete if it has associated client requests
        return $this->clientRequests()->count() === 0;
    }
}
