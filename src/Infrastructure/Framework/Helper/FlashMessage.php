<?php

namespace Infrastructure\Framework\Helper;

class FlashMessage
{
    private const SUCCESS_KEY = 'flash_success';
    private const ERROR_KEY = 'flash_error';
    private const INFO_KEY = 'flash_info';

    public static function setSuccess(string $message): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION[self::SUCCESS_KEY] = $message;
    }

    public static function setError(string $message): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION[self::ERROR_KEY] = $message;
    }

    public static function setInfo(string $message): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION[self::INFO_KEY] = $message;
    }

    public static function getSuccess(): ?string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $msg = $_SESSION[self::SUCCESS_KEY] ?? null;
        unset($_SESSION[self::SUCCESS_KEY]);
        return $msg;
    }

    public static function getError(): ?string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $msg = $_SESSION[self::ERROR_KEY] ?? null;
        unset($_SESSION[self::ERROR_KEY]);
        return $msg;
    }

    public static function getInfo(): ?string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $msg = $_SESSION[self::INFO_KEY] ?? null;
        unset($_SESSION[self::INFO_KEY]);
        return $msg;
    }
}
