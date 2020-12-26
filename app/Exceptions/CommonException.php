<?php

namespace App\Exceptions;

use Exception;
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
        Log::error('Ошибка шлюза: [' . $this->getMessage() . '] Код ответа: [' . $this->getCode() . ']');
    }
}
