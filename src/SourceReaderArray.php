<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag;

use InvalidArgumentException;

/**
 * Object that reades and checks configuration from array.
 */
class SourceReaderArray implements SourceReader
{
    public const SOURCE_TYPE_ARRAY = 'array';

    /**
     * {@inheritDoc}
     */
    public function supports(string $type, $source): bool
    {
        return $type === self::SOURCE_TYPE_ARRAY;
    }

    /**
     * {@inheritDoc}
     */
    public function read(string $type, $source): array
    {
        if (!is_array($source)) {
            $message = 'Source item must be an instance of array.';
            throw new InvalidArgumentException($message);
        }

        return $source;
    }
}
