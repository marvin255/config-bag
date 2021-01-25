<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag;

use InvalidArgumentException;

/**
 * Object that can create config bag item.
 */
interface ConfigBagBuilder
{
    /**
     * Loads configuration data from set source type.
     *
     * @param string $sourceType
     * @param mixed  $source
     *
     * @return ConfigBagBuilder
     *
     * @throws InvalidArgumentException
     */
    public function loadSource(string $sourceType, $source): ConfigBagBuilder;

    /**
     * Returns config bag builded with all data from resources.
     *
     * @return ConfigBag
     */
    public function build(): ConfigBag;
}
