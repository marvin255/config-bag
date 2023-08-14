<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag;

/**
 * Object that reades and checks configuration from json file.
 *
 * @internal
 */
final class SourceReaderJsonFile implements SourceReader
{
    public const SOURCE_TYPE_JSON_FILE = 'json_file';

    /**
     * {@inheritDoc}
     */
    public function supports(string $type, mixed $source): bool
    {
        return $type === self::SOURCE_TYPE_JSON_FILE;
    }

    /**
     * {@inheritDoc}
     */
    public function read(string $type, mixed $source): array
    {
        if (\is_string($source)) {
            $source = new \SplFileInfo($source);
        }

        if (!($source instanceof \SplFileInfo)) {
            throw new \InvalidArgumentException('Source item must be an instance of string or SplFileInfo');
        }

        if (!$source->isFile() || !$source->isReadable()) {
            throw new \InvalidArgumentException('Source file must be existed an readable');
        }

        $content = file_get_contents($source->getRealPath());
        $config = json_decode($content, true, 512, \JSON_THROW_ON_ERROR);

        return \is_array($config) ? $config : [];
    }
}
