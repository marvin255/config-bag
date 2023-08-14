<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag;

/**
 * Object that reades and checks configuration from array.
 *
 * @internal
 */
final class SourceReaderArray implements SourceReader
{
    public const SOURCE_TYPE_ARRAY = 'array';

    /**
     * {@inheritDoc}
     */
    public function supports(string $type, mixed $source): bool
    {
        return $type === self::SOURCE_TYPE_ARRAY;
    }

    /**
     * {@inheritDoc}
     */
    public function read(string $type, mixed $source): array
    {
        if (!\is_array($source)) {
            throw new \InvalidArgumentException('Source item must be an instance of array');
        }

        return $source;
    }
}
