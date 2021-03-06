<?php

namespace Phine\Compact\Exception;

/**
 * Exception thrown for XML related errors.
 *
 * Summary
 * -------
 *
 * The `XmlException` class is thrown when there is an issue parsing an XML
 * document. The class will use the internal libxml error handling mechanism
 * to find error messages for reporting.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class XmlException extends CompactException
{
    /**
     * The previous "use internal error" state.
     *
     * @var boolean
     */
    private $internal;

    /**
     * Creates a new exception using the most recent libxml errors.
     *
     * This method will create a new exception using all of th error messages
     * in the libxml error buffer. The message will contain each error message,
     * along with the affected file name, line number, and column number.
     *
     *     throw XmlException::createUsingLastXmlError();
     *
     * @return XmlException The new exception.
     */
    public function createUsingLastXmlError()
    {
        $errors = array();
        $count = 0;

        /** @var \libXMLError $error */
        foreach (libxml_get_errors() as $error) {
            $errors[] = sprintf(
                '#%d.) "%s" in %s line %d column %d.',
                ++$count,
                trim($error->message),
                $error->file,
                $error->line,
                $error->column
            );
        }

        $this->finish();

        if (empty($errors)) {
            $errors[] = '(unknown error)';
        }

        return new self(join("\n", $errors));
    }

    /**
     * Restores the internal error handling state.
     *
     * This method will restore the previous internal error setting for the
     * libxml library. The setting restored was retrieved by the `start()`
     * method.
     */
    public function finish()
    {
        libxml_use_internal_errors($this->internal);
    }

    /**
     * Enables internal error handling and clears the error buffer.
     *
     * This method will enable the use of internal errors in the libxml
     * library. The libxml error buffer will also be cleared. The previous
     * setting for using internal errors will be saved so that it can be
     * later restored.
     */
    public function start()
    {
        $this->internal = libxml_use_internal_errors(true);

        libxml_clear_errors();
    }
}
