<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag;

/**
 * Interface for object that stores configuration options.
 */
interface ConfigBag
{
    /**
     * Returns true if option with set name exists.
     */
    public function has(string $name): bool;

    /**
     * Returns option value associated with set name as string.
     *
     * @throws \RuntimeException
     */
    public function string(string $name, string $default = ''): string;

    /**
     * Returns option value associated with set name as string or throw an exception.
     *
     * @throws \RuntimeException
     */
    public function stringRequired(string $name): string;

    /**
     * Returns option value associated with set name as int.
     *
     * @throws \RuntimeException
     */
    public function int(string $name, int $default = 0): int;

    /**
     * Returns option value associated with set name as int or throw an exception.
     *
     * @throws \RuntimeException
     */
    public function intRequired(string $name): int;

    /**
     * Returns option value associated with set name as float.
     *
     * @throws \RuntimeException
     */
    public function float(string $name, float $default = .0): float;

    /**
     * Returns option value associated with set name as float or throw an exception.
     *
     * @throws \RuntimeException
     */
    public function floatRequired(string $name): float;

    /**
     * Returns option value associated with set name as bool.
     *
     * @throws \RuntimeException
     */
    public function bool(string $name, bool $default = false): bool;

    /**
     * Returns option value associated with set name as bool or throw an exception.
     *
     * @throws \RuntimeException
     */
    public function boolRequired(string $name): bool;

    /**
     * Returns option value associated with set name as array.
     *
     * @throws \RuntimeException
     */
    public function array(string $name, array $default = []): array;
}
