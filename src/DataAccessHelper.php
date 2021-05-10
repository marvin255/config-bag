<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag;

/**
 * Helper that allows to access hierarchical data via dot syntax.
 */
class DataAccessHelper
{
    /**
     * Returns data by set path.
     *
     * @param string $path
     * @param mixed  $data
     *
     * @return mixed
     */
    public static function get(string $path, $data)
    {
        $arPath = self::explodePath($path);

        $item = $data;
        foreach ($arPath as $chainItem) {
            if (\is_array($item) && \array_key_exists($chainItem, $item)) {
                $item = $item[$chainItem];
            } elseif (\is_object($item) && property_exists($item, $chainItem)) {
                $item = $item->$chainItem;
            } else {
                $item = null;
                break;
            }
        }

        return $item;
    }

    /**
     * Explodes dotted path to array of items.
     *
     * @param string $path
     *
     * @return array
     */
    private static function explodePath(string $path): array
    {
        return explode('.', trim($path, " \n\r\t\v\0."));
    }
}
