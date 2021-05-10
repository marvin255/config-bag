<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag;

use InvalidArgumentException;
use SplFileInfo;

/**
 * Object that reades and checks configuration from php file.
 */
class SourceReaderPhpFile implements SourceReader
{
    public const SOURCE_TYPE_PHP_FILE = 'php_file';

    /**
     * {@inheritDoc}
     */
    public function supports(string $type, $source): bool
    {
        return $type === self::SOURCE_TYPE_PHP_FILE;
    }

    /**
     * {@inheritDoc}
     *
     * @psalm-suppress UnresolvableInclude
     */
    public function read(string $type, $source): array
    {
        if (\is_string($source)) {
            $source = new SplFileInfo($source);
        }

        if (!($source instanceof SplFileInfo)) {
            $message = 'Source item must be an instance of string or SplFileInfo.';
            throw new InvalidArgumentException($message);
        }

        if (!$source->isFile() || !$source->isReadable()) {
            $message = 'Source file must be existed and readable.';
            throw new InvalidArgumentException($message);
        }

        $config = include $source->getRealPath();

        return \is_array($config) ? $config : [];
    }
}
