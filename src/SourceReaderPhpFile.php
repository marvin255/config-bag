<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag;

/**
 * Object that reades and checks configuration from php file.
 *
 * @internal
 */
final class SourceReaderPhpFile implements SourceReader
{
    public const SOURCE_TYPE_PHP_FILE = 'php_file';

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function supports(string $type, mixed $source): bool
    {
        return $type === self::SOURCE_TYPE_PHP_FILE;
    }

    /**
     * {@inheritDoc}
     *
     * @psalm-suppress UnresolvableInclude
     */
    #[\Override]
    public function read(string $type, mixed $source): array
    {
        if (\is_string($source)) {
            $source = new \SplFileInfo($source);
        }

        if (!($source instanceof \SplFileInfo)) {
            throw new \InvalidArgumentException('Source item must be an instance of string or SplFileInfo');
        }

        if (!$source->isFile() || !$source->isReadable()) {
            throw new \InvalidArgumentException('Source file must be existed and readable');
        }

        $config = include $source->getRealPath();

        return \is_array($config) ? $config : [];
    }
}
