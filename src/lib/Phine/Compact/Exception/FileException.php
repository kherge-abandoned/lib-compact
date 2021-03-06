<?php

namespace Phine\Compact\Exception;

use Phine\Exception\Exception;

/**
 * Exception thrown for file system related errors.
 *
 * Summary
 * -------
 *
 * The `FileException` class may be thrown by a compactor if a file it is
 * attempting to compact cannot be read. This could be due to a variety of
 * reasons, such as the file not existing, a bad network connection, or even
 * running out of memory.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class FileException extends Exception
{
}
