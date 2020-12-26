<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CommonException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        Log::error('Ошибка: [' . $this->getMessage() . '] Код ответа: [' . $this->getCode() . ']');
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     */
    public function render()
    {
        return response()->json(['message' => $this->getMessage()], $this->getCode());
    }
}
