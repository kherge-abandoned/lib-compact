<?php

namespace Phine\Compact;

use DOMDocument;
use Phine\Compact\Exception\XmlException;

/**
 * Compacts the contents of XML files.
 *
 * Summary
 * -------
 *
 * The `Xml` class will compact XML documents simply by loading and saving
 * them without formatting the output or preserving whitespace.
 *
 * Starting
 * --------
 *
 * To start, you will need to create an instance of `Xml`.
 *
 *     use Phine\Compact\Xml;
 *
 *     $xml = new Xml();
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Xml extends AbstractCompact
{
    /**
     * {@inheritDoc}
     */
    protected $extensions = array('xml');

    /**
     * {@inheritDoc}
     */
    public function compactContents($contents)
    {
        $exception = new XmlException();
        $exception->start();

        $doc = new DOMDocument();
        $doc->formatOutput = false;
        $doc->preserveWhiteSpace = false;

        if (!$doc->loadXML($contents)) {
            throw $exception->createUsingLastXmlError();
        }

        $exception->finish();

        return trim($doc->saveXML());
    }
}
