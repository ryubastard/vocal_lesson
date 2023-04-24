<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesUsers;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeleteUserMail;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(User $user): void
    {
        Mail::to($user->email)
            ->queue(new DeleteUserMail());
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->lessons()->detach();
        $user->delete();
    }
}
