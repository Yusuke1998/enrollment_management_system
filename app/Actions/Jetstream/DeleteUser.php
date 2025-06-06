<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(User $user): void
    {
        if ($user->id == 1) return;
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();
    }
}
