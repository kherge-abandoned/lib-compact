<?php

namespace Phine\Compact\Exception;

if (!defined('JSON_ERROR_RECURSION')) {
    /**
     * One or more recursive references in the value to be encoded.
     */
    define('JSON_ERROR_RECURSION', 6);
}

if (!defined('JSON_ERROR_INF_OR_NAN')) {
    /**
     * One or more NAN or INF values in the value to be encoded .
     */
    define('JSON_ERROR_INF_OR_NAN', 7);
}

if (!defined('JSON_ERROR_UNSUPPORTED_TYPE')) {
    /**
     * A value of a type that cannot be encoded was given.
     */
    define('JSON_ERROR_UNSUPPORTED_TYPE', 8);
}

/**
 * Exception thrown for JSON related errors.
 *
 * Summary
 * -------
 *
 * The `JsonException` class is thrown when there is an issue decoding some
 * JSON data. The class recognizes error codes from PHP 5.3.3, in addition to
 * PHP 5.5.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class JsonException extends CompactException
{
    /**
     * The recognized JSON error codes.
     *
     * @var array
     */
    private static $errors = array(
        JSON_ERROR_NONE => 'No error has occurred.',
        JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded.',
        JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON.',
        JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded.',
        JSON_ERROR_SYNTAX => 'Syntax error.',
        JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded.',
        JSON_ERROR_RECURSION => 'One or more recursive references in the value to be encoded.',
        JSON_ERROR_INF_OR_NAN => 'One or more NAN or INF values in the value to be encoded.',
        JSON_ERROR_UNSUPPORTED_TYPE => 'A value of a type that cannot be encoded was given.',
    );

    /**
     * Creates a new exception for the last JSON error.
     *
     * This method will create a new exception for the last JSON error.
     *
     *     throw JsonException::createUsingLastJsonError();
     *
     * @return JsonException The new exception.
     */
    public static function createUsingLastJsonError()
    {
        return new self(self::$errors[json_last_error()]);
    }
}
