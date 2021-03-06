<?php

namespace Phine\Compact;

use Phine\Compact\Exception\JsonException;

/**
 * Compacts the contents of JSON files.
 *
 * Summary
 * -------
 *
 * The `Json` class will compact JSON contents simply by decoding and recoding
 * it without pretty printing. If the version of PHP supports it, the unicode
 * characters will be re-encoded unescaped.
 *
 * Starting
 * --------
 *
 * To start, you will need to create an instance of `Json`.
 *
 *     use Phine\Compact\Json;
 *
 *     $json = new Json();
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Json extends AbstractCompact
{
    /**
     * {@inheritDoc}
     */
    protected $extensions = array('json');

    /**
     * The encoding options.
     *
     * @var integer
     */
    private $options = 0;

    /**
     * Checks support for unescaped unicode.
     */
    public function __construct()
    {
        if (version_compare(phpversion(), '5.4', '>=')) {
            $this->options = JSON_UNESCAPED_UNICODE;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function compactContents($contents)
    {
        $contents = json_decode($contents);

        if (JSON_ERROR_NONE !== ($code = json_last_error())) {
            throw JsonException::createUsingLastJsonError();
        }

        return json_encode($contents, $this->options);
    }
}
