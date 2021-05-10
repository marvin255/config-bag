<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag;

use RuntimeException;

/**
 * Object that stores configuration options in internal array.
 */
class ConfigBagArray implements ConfigBag
{
    /**
     * @var mixed
     */
    private $options;

    /**
     * @param mixed $options
     */
    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $name): bool
    {
        return DataAccessHelper::get($name, $this->options) !== null;
    }

    /**
     * {@inheritDoc}
     */
    public function string(string $name, string $default = ''): string
    {
        $option = $this->getScalarOption($name);

        return $option === null ? $default : (string) $option;
    }

    /**
     * {@inheritDoc}
     */
    public function stringRequired(string $name): string
    {
        return (string) $this->getRequiredScalarOption($name);
    }

    /**
     * {@inheritDoc}
     */
    public function int(string $name, int $default = 0): int
    {
        $option = $this->getScalarOption($name);

        return $option === null ? $default : (int) $option;
    }

    /**
     * {@inheritDoc}
     */
    public function intRequired(string $name): int
    {
        return (int) $this->getRequiredScalarOption($name);
    }

    /**
     * {@inheritDoc}
     */
    public function float(string $name, float $default = .0): float
    {
        $option = $this->getScalarOption($name);

        return $option === null ? $default : (float) $option;
    }

    /**
     * {@inheritDoc}
     */
    public function floatRequired(string $name): float
    {
        return (float) $this->getRequiredScalarOption($name);
    }

    /**
     * {@inheritDoc}
     */
    public function bool(string $name, bool $default = false): bool
    {
        $option = $this->getScalarOption($name);

        return $option === null ? $default : (bool) $option;
    }

    /**
     * {@inheritDoc}
     */
    public function boolRequired(string $name): bool
    {
        return (bool) $this->getRequiredScalarOption($name);
    }

    /**
     * {@inheritDoc}
     */
    public function array(string $name, array $default = []): array
    {
        $option = $this->getOption($name);

        if ($option !== null && !\is_array($option)) {
            $message = sprintf("Can't return non array option '%s' as array.", $name);
            throw new RuntimeException($message);
        }

        return $option === null ? $default : $option;
    }

    /**
     * Returns scalar option value by set name.
     *
     * @param string $name
     *
     * @return mixed
     */
    private function getScalarOption(string $name)
    {
        $option = $this->getOption($name);

        if ($option !== null && !is_scalar($option)) {
            $message = sprintf("Value for option '%s' must be scalar.", $name);
            throw new RuntimeException($message);
        }

        return $option;
    }

    /**
     * Returns option value by set name or throw an exception.
     *
     * @param string $name
     *
     * @return mixed
     */
    private function getRequiredScalarOption(string $name)
    {
        $option = $this->getOption($name);

        if ($option === null || !is_scalar($option)) {
            $message = sprintf("Required option '%s' not found.", $name);
            throw new RuntimeException($message);
        }

        return $option;
    }

    /**
     * Returns option value by set name.
     *
     * @param string $name
     *
     * @return mixed
     */
    private function getOption(string $name)
    {
        return DataAccessHelper::get($name, $this->options);
    }
}
