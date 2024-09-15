<?php

declare(strict_types=1);

namespace App\Config;

use DateTime;
use InvalidArgumentException;


class Logger
{
    private static string $logFile = 'app.log';
    private static int $maxFileSize = 1048576; // Máximo tamanho do arquivo em bytes
    private const PATH = "logs".DIRECTORY_SEPARATOR; 

    private const LOG_LEVELS = ['DEBUG', 'INFO', 'WARN', 'ERROR'];

    public static function setLogFile(string $logFile): void
    {
        self::$logFile = $logFile;
    }

    public static function setMaxFileSize(int $maxFileSize): void
    {
        self::$maxFileSize = $maxFileSize;
    }

    private static function rotateLog(): void
    {
        if (file_exists(self::$logFile) && filesize(self::$logFile) > self::$maxFileSize) {
            $dateTime = (new DateTime())->format('Ymd_His');
            rename(self::$logFile, self::$logFile . '.' . $dateTime);
        }
    }

    public static function log(string $level, string $message): void
    {

        if (!in_array($level, self::LOG_LEVELS)) {
            throw new InvalidArgumentException("Invalid log level: $level");
        }

        if (!is_dir(self::PATH)){
            mkdir(self::PATH, 0755, true);
        }

        self::rotateLog();
        $dateTime = (new DateTime())->format('Y-m-d H:i:s');
        $logMessage = "[$dateTime] [$level] $message" . PHP_EOL;

        file_put_contents(self::PATH.self::$logFile, $logMessage, FILE_APPEND | LOCK_EX);
    }

    public static function debug(string $message): void
    {
        self::log('DEBUG', $message);
    }

    public static function info(string $message): void
    {
        self::log('INFO', $message);
    }

    public static function warn(string $message): void
    {
        self::log('WARN', $message);
    }

    public static function error(string $message): void
    {
        self::log('ERROR', $message);
    }
}
