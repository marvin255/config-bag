<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag;

use RuntimeException;

/**
 * Interface for object that stores configuration options.
 */
interface ConfigBag
{
    /**
     * Returns true if option with set name exists.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Returns option value associated with set name as string.
     *
     * @param string $name
     * @param string $default
     *
     * @return string
     *
     * @throws RuntimeException
     */
    public function string(string $name, string $default = ''): string;

    /**
     * Returns option value associated with set name as int.
     *
     * @param string $name
     * @param int    $default
     *
     * @return int
     *
     * @throws RuntimeException
     */
    public function int(string $name, int $default = 0): int;

    /**
     * Returns option value associated with set name as float.
     *
     * @param string $name
     * @param float  $default
     *
     * @return float
     *
     * @throws RuntimeException
     */
    public function float(string $name, float $default = .0): float;

    /**
     * Returns option value associated with set name as bool.
     *
     * @param string $name
     * @param bool   $default
     *
     * @return bool
     *
     * @throws RuntimeException
     */
    public function bool(string $name, bool $default = false): bool;

    /**
     * Returns option value associated with set name as array.
     *
     * @param string $name
     * @param array  $default
     *
     * @return array
     *
     * @throws RuntimeException
     */
    public function array(string $name, array $default = []): array;
}
