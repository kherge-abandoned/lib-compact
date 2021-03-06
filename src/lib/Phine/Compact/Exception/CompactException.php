<?php

namespace Phine\Compact\Exception;

use Phine\Exception\Exception;

/**
 * Exception thrown for compactor related errors.
 *
 * Summary
 * -------
 *
 * The `CompactException` class may be thrown when a compactor may not be
 * able to compact the given contents. This may be due to invalid syntax,
 * character encoding, and other content related issues.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class CompactException extends Exception
{
}
