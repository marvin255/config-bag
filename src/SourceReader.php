<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag;

/**
 * Object that can read configuration data from set source.
 */
interface SourceReader
{
    /**
     * Returns true if reader can read set source.
     */
    public function supports(string $type, mixed $source): bool;

    /**
     * Reads configuration from set source.
     *
     * @throws \InvalidArgumentException
     */
    public function read(string $type, mixed $source): array;
}
