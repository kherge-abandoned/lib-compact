<?php

namespace Phine\Compact;

/**
 * Compacts the contents of PHP files.
 *
 * Summary
 * -------
 *
 * The `Php` class will compact PHP contents by removing all comments and
 * reducing the quantity whitespace in the remaining lines. Line breaks are
 * preserved for the purpose of aiding in the debugging process. If line
 * count is preserved, developers will be able to view the original source
 * code using the file name and line number from the error message for the
 * compacted source.
 *
 * Starting
 * --------
 *
 * To start, you will need to create an instance of `Php`.
 *
 *     use Phine\Compact\Php;
 *
 *     $php = new Php();
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Jordi Boggiano <j.boggiano@seld.be>
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Php extends AbstractCompact
{
    /**
     * {@inheritDoc}
     */
    protected $extensions = array('php');

    /**
     * {@inheritDoc}
     */
    public function compactContents($contents)
    {
        $output = '';

        foreach (token_get_all($contents) as $token) {
            if (is_string($token)) {
                $output .= $token;
            } elseif (in_array($token[0], array(T_COMMENT, T_DOC_COMMENT))) {
                $output .= str_repeat("\n", substr_count($token[1], "\n"));
            } elseif (T_WHITESPACE === $token[0]) {
                $whitespace = preg_replace('{[ \t]+}', ' ', $token[1]);
                $whitespace = preg_replace('{(?:\r\n|\r|\n)}', "\n", $whitespace);
                $whitespace = preg_replace('{\n +}', "\n", $whitespace);
                $output .= $whitespace;
            } else {
                $output .= $token[1];
            }
        }

        return trim($output);
    }
}
