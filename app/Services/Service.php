<?php

namespace App\Services;

use Exception, Log, DB;
use App\Exceptions\ActionFailedException;

class Service
{
    /**
     * @param Exception $exception
     * @param           $message
     * @param bool      $withLog
     *
     * @return \Exception
     * @throws ActionFailedException
     */
    protected function handleTransactionException(Exception $exception, $message = null, $withLog = true): void
    {
        DB::rollBack();

        if ($withLog) {
            $this->logException($exception);
        }

        throw new ActionFailedException($message ?: $exception->getMessage(), 500, $exception);
    }

    protected function logException($exception)
    {
        Log::error($exception->getMessage());
        Log::error($exception->getTraceAsString());
    }
}