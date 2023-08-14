<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag;

/**
 * Object that can create config bag item.
 */
interface ConfigBagBuilder
{
    /**
     * Loads configuration data from set source type.
     *
     * @throws \InvalidArgumentException
     */
    public function loadSource(string $sourceType, mixed $source): ConfigBagBuilder;

    /**
     * Returns config bag builded with all data from resources.
     */
    public function build(): ConfigBag;
}
