<?php

namespace Service;

class LoggerService
{
    public function errors($exception): void
    {
        $errorMessage = sprintf(
            "[%s] Ошибка: %s в %s на строке %d. Код: %d\n",
            date('Y-m-d H:i:s'), // Дата и время
            $exception->getMessage(), // Сообщение об ошибке
            $exception->getFile(), // Файл, где произошла ошибка
            $exception->getLine(), // Строка, где произошла ошибка
            $exception->getCode() // Код ошибки
        );

        file_put_contents('./../Storage/Log/errors.txt', $errorMessage, FILE_APPEND);
        require_once './../Views/505.php';
    }

}