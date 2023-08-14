<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag;

/**
 * Object that stores configuration options in internal array.
 *
 * @internal
 */
final class ConfigBagArray implements ConfigBag
{
    public function __construct(private readonly mixed $options)
    {
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
            throw new \RuntimeException("Can't return non array option {$name} as array");
        }

        return $option === null ? $default : $option;
    }

    /**
     * Returns scalar option value by set name.
     *
     * @return mixed
     */
    private function getScalarOption(string $name)
    {
        $option = $this->getOption($name);

        if ($option !== null && !\is_scalar($option)) {
            throw new \RuntimeException("Value for option {$name} must be scalar");
        }

        return $option;
    }

    /**
     * Returns option value by set name or throw an exception.
     *
     * @return mixed
     */
    private function getRequiredScalarOption(string $name)
    {
        $option = $this->getOption($name);

        if ($option === null || !\is_scalar($option)) {
            throw new \RuntimeException("Required option {$name} not found");
        }

        return $option;
    }

    /**
     * Returns option value by set name.
     *
     * @return mixed
     */
    private function getOption(string $name)
    {
        return DataAccessHelper::get($name, $this->options);
    }
}
