<?php

namespace App\Services;

use App\Models\User;

use Hash, DB, Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserService extends Service
{

    /**
     * Gets list of users
     *
     * @return Collection
     */
    public function getListUsers()
    {
        return User::paginate();
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

            $user->lineReads()->delete();
            $user->timeReads()->delete();

            return $user->delete();

            DB::commit();
        } catch (Throwable $exception) {
            return $this->handleTransactionException($exception);
        }

        return false;
    }
}
