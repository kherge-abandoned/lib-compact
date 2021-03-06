<?php

namespace Phine\Compact;

use Phine\Compact\Exception\FileException;

/**
 * Provides the basis for a compactor class.
 *
 * Summary
 * -------
 *
 * The `AbstractCompact` class provides a foundation in which new compactor
 * classes can be easily created. The abstract class implements the basic
 * methods such as `compactFile()` and `isSupported()`, leaving only the
 * `compactContents()` method to be defined as well as a list of supported
 * file extensions.
 *
 * Starting
 * --------
 *
 * To use the `AbstractCompact` class, you will need to create your own.
 *
 *     class Text extends AbstractCompact
 *     {
 *         protected $extensions = array('txt');
 *
 *         public function compactContents($contents)
 *         {
 *             return preg_replace('/\s+/', ' ', $contents);
 *         }
 *     }
 *
 * The abstract class will take care of reading files and checking if the
 * file extension is supported. It will also allow developers to change the
 * default list of supported extensions.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
abstract class AbstractCompact implements CompactInterface
{
    /**
     * The supported file extensions.
     *
     * @var array
     */
    protected $extensions = array();

    /**
     * {@inheritDoc}
     */
    public function compactFile($file)
    {
        if (false === ($contents = @file_get_contents($file))) {
            throw FileException::createUsingLastError();
        }

        return $this->compactContents($contents);
    }

    /**
     * {@inheritDoc}
     */
    public function isSupported($extension)
    {
        return in_array($extension, $this->extensions);
    }

    /**
     * Overrides the default list of supported file extensions.
     *
     * This method will allow you to override the list of default supported
     * extensions. This may be useful if non-standard file extensions or older
     * file naming conventions are used.
     *
     *     $compactor->setExtensions(array('php', 'phtml', 'php5', 'php4'));
     *
     * @param array $extensions The list of file extensions.
     */
    public function setExtensions(array $extensions)
    {
        $this->extensions = $extensions;
    }
}
