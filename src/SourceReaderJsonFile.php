<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag;

use InvalidArgumentException;
use SplFileInfo;

/**
 * Object that reades and checks configuration from json file.
 */
class SourceReaderJsonFile implements SourceReader
{
    public const SOURCE_TYPE_JSON_FILE = 'json_file';

    /**
     * {@inheritDoc}
     */
    public function supports(string $type, $source): bool
    {
        return $type === self::SOURCE_TYPE_JSON_FILE;
    }

    /**
     * {@inheritDoc}
     */
    public function read(string $type, $source): array
    {
        if (is_string($source)) {
            $source = new SplFileInfo($source);
        }

        if (!($source instanceof SplFileInfo)) {
            $message = 'Source item must be an instance of string or SplFileInfo.';
            throw new InvalidArgumentException($message);
        }

        if (!$source->isFile() || !$source->isReadable()) {
            $message = 'Source file must be existed an readable.';
            throw new InvalidArgumentException($message);
        }

        $content = file_get_contents($source->getRealPath());
        $config = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        return is_array($config) ? $config : [];
    }
}
