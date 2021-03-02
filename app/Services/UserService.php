<?php

namespace App\Services;

use App\Models\User;

use Hash, DB, Log;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class UserService extends Service
{

    /**
     * Gets list of users
     *
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return User::get();
    }

    /**
     * Deletes a user
     *
     * @param User $user
     * @return bool
     * @throws Exception
     */
    public function delete(User $user): bool
    {
        try {
            DB::beginTransaction();

            return $user->delete();

            DB::commit();
        } catch (Exception $exception) {
            return $this->handleTransactionException($exception);
        }

        return $user;
    }
}
