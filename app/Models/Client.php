<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'location',
        'contact_person',
        'address',
        'notes',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the requests associated with this client
     */
    public function requests(): HasMany
    {
        return $this->hasMany(ClientRequest::class);
    }

    /**
     * Get the portal users associated with this client
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the user who created this client
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to filter active clients
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the count of pending requests for this client
     */
    public function getPendingRequestsCountAttribute()
    {
        // Since completed_at column doesn't exist, we consider all requests as pending
        return $this->requests()->count();
    }

    /**
     * Scope to filter clients visible to a user
     */
    public function scopeVisibleTo($query, User $user)
    {
        if ($user->hasRole('Super Admin') || $user->can('manage users')) {
            return $query;
        }

        if ($user->isClient()) {
            return $query->where('id', $user->client_id);
        }

        return $query->where('created_by', $user->id);
    }

    /**
     * Get initials from client name for avatar
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }
}
