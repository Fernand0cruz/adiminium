<?php

namespace App\Traits;

use App\Exceptions\AdminAlreadyExistsException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Exceptions\MaxQuantityExceededException;

trait HandlesExceptions
{
    public function handleExceptions(callable $callback, $notFoundStatus = 404, $notFoundMessage = 'Resource not found.')
    {
        try {
            return $callback();
        } catch (ModelNotFoundException $e) {
            return $this->error($notFoundMessage, $notFoundStatus);
        } catch (AdminAlreadyExistsException $e) {
            return $this->error('An ADMIN is already registered in the system.', 422);
        } catch (MaxQuantityExceededException $e) {
            return $this->error('Maximum stock limit reached.', 422);
        } catch (QueryException $e) {
            Log::error('Database query error: ' . $e->getMessage());
            return $this->error('Database error. Please try again later.', 500);
        } catch (Throwable $e) {
            Log::error('Unexpected error: ' . $e->getMessage());
            return $this->error('An unexpected error occurred.', 500);
        }
    }
}
