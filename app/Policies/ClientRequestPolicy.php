<?php

namespace App\Policies;

use App\Models\ClientRequest;
use App\Models\User;

class ClientRequestPolicy
{
    /**
     * Determine if the user can view any client requests.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view requests');
    }

    /**
     * Determine if the user can view the client request.
     */
    public function view(User $user, ClientRequest $clientRequest): bool
    {
        // Super Admin or users with manage permission can view all
        if ($user->hasRole('Super Admin') || $user->can('manage users')) {
            return true;
        }

        // Check if user has view permission AND is assigned to the request
        if ($user->can('view requests')) {
            return $clientRequest->assignees()->where('user_id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Determine if the user can create client requests.
     */
    public function create(User $user): bool
    {
        return $user->can('create requests');
    }

    /**
     * Determine if the user can update the client request.
     */
    public function update(User $user, ClientRequest $clientRequest): bool
    {
        // Super Admin or users with manage permission can update all
        if ($user->hasRole('Super Admin') || $user->can('manage users')) {
            return $user->can('edit requests');
        }

        // Check if user has edit permission AND is assigned to the request
        if ($user->can('edit requests')) {
            return $clientRequest->assignees()->where('user_id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Determine if the user can delete the client request.
     */
    public function delete(User $user, ClientRequest $clientRequest): bool
    {
        // Only Super Admin or users with manage permission can delete
        if ($user->hasRole('Super Admin') || $user->can('manage users')) {
            return $user->can('delete requests');
        }

        return false;
    }
}
