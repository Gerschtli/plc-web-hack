<?hh // strict

namespace PLC;

/**
 * Static Configuration class
 *
 * Provides database credentials.
 */
class Config
{
    public static string $HOST = 'localhost';
    public static int $PORT = 3306;
    public static string $DB = 'blog';
    public static string $USER = 'plc';
    public static string $PASSWORD = 'test';
}
