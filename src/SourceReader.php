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
     *
     * @param string $type
     * @param mixed  $source
     *
     * @return bool
     */
    public function supports(string $type, $source): bool;

    /**
     * Reads configuration from set source.
     *
     * @param string $type
     * @param mixed  $source
     *
     * @return array
     */
    public function read(string $type, $source): array;
}
