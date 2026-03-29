<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'status_id',
        'request_date',
        'start_date',
        'deadline_date',
        'title',
        'responsible',
        'contact_email',
        'contact_phone',
        'source',
        'context',
        'cancellation_reason',
        'expected_result_description',
        'request_types',
        'expected_results',
        'documents',
        'created_by',
    ];

    protected $casts = [
        'request_date' => 'datetime',
        'start_date' => 'datetime',
        'deadline_date' => 'datetime',
        'request_types' => 'array',
        'expected_results' => 'array',
        'documents' => 'array',
    ];

    /**
     * Get the client associated with this request
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the user who created this request
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the status of this request
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(RequestStatus::class, 'status_id');
    }

    /**
     * Scope to filter by client
     */
    public function scopeForClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    /**
     * Scope to filter by status
     */
    public function scopeWithStatus($query, $statusId)
    {
        return $query->where('status_id', $statusId);
    }

    /**
     * Scope to filter by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('request_date', [$startDate, $endDate]);
    }
    
    /**
     * Get the users assigned to the request
     */
    public function assignees(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'client_request_user')
            ->withTimestamps();
    }

    /**
     * Scope to filter requests visible to a specific user
     */
    public function scopeVisibleTo($query, User $user)
    {
        // Super Admin or users with manage permission can see all
        if ($user->hasRole('Super Admin') || $user->can('manage users')) {
            return $query;
        }

        // Regular users only see requests they are assigned to
        return $query->whereHas('assignees', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });
    }
}
