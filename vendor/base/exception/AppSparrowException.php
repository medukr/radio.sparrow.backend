<?php
/**
 * Created by andrii
 * Date: 29.05.19
 * Time: 14:36
 */

namespace app\exception;


use Throwable;

class AppSparrowException extends SparrowException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function pushException()
    {
        //Произойдет запись логов и вернет пользователю ответ со стандартным сообщением
        $this->pushResponseMessage();
    }
}