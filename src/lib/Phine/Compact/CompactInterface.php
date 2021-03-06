<?php

namespace Phine\Compact;

use Phine\Compact\Exception\CompactException;
use Phine\Compact\Exception\FileException;

/**
 * Defines how a compacting class must be implemented.
 *
 * Summary
 * -------
 *
 * A class implementing `CompactInterface` will be capable of reducing the
 * size of supported content. The compacted result is expected to be smaller
 * but still usable as if it had never been compacted. In most cases, this
 * would simply be a case of reducing the amount of whitespace the contents
 * contain, but how this process is achieved will vary depending on the type
 * of the contents.
 *
 * Starting
 * --------
 *
 * To create a new compactor, you will need to create your own implementation
 * of `CompactInterface`. In this example, I will create a simple compactor
 * that will convert sequential white space into a single space.
 *
 *     use Phine\Compact\CompactInterface;
 *
 *     class Whitespace implements CompactInterface
 *     {
 *         public function compactContents($contents)
 *         {
 *             return preg_replace('/\s+/', ' ', $contents);
 *         }
 *
 *         public function compactFile($file)
 *         {
 *             return $this->compactContents(file_get_contents($file));
 *         }
 *
 *         public function isSupported($extension)
 *         {
 *             return ('txt' === $extension);
 *         }
 *     }
 *
 * Using the `Whitespace` compactor, we can shorten strings.
 *
 *     $compactor = new Whitespace();
 *
 *     echo $compactor->compactContents('    extra leading space');
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
interface CompactInterface
{
    /**
     * Returns the compacted version of the given contents.
     *
     * This method will compact the given contents and return the result.
     * If an error occurred during the compacting process, an exception
     * is be thrown.
     *
     *     $compactedContents = $compactor->compactContents($contents);
     *
     * @param string $contents The contents.
     *
     * @return string The compacted contents.
     *
     * @throws CompactException If the contents could not be compacted.
     */
    public function compactContents($contents);

    /**
     * Returns the compacted contents of the file.
     *
     * This method will read the contents of the file and returned the
     * compacted contents. If an error occurred during the reading or
     * compacting process, an exception is thrown.
     *
     *     $compactedContents = $compactor->compactFile(/path/to/file');
     *
     * @param string $file The path to the file.
     *
     * @return string The compacted contents.
     *
     * @throws CompactException If the contents could not be compacted.
     * @throws FileException    If the file could not be read.
     */
    public function compactFile($file);

    /**
     * Checks if the file extension is supported.
     *
     * This method will check to see if the file extension is supported by
     * this compactor class. If the file extension is supported, `true` is
     * returned.
     *
     *     if ($compactor->isSupported('extension')) {
     *         $contents = $compactor->compactContents($contents);
     *     }
     *
     * @param string $extension The file extension.
     *
     * @return boolean If the file extension is supported, `true` is returned.
     *                 If the file extension is not supported, `false` is
     *                 returned.
     */
    public function isSupported($extension);
}
