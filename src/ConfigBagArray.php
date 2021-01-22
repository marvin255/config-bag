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
     * @var array<string, mixed>
     */
    private array $options;

    public function __construct(iterable $options)
    {
        $this->options = [];
        foreach ($options as $name => $value) {
            $unifiedName = $this->unifyOptionName((string) $name);
            $this->options[$unifiedName] = $value;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $name): bool
    {
        $unifiedName = $this->unifyOptionName($name);

        return array_key_exists($unifiedName, $this->options);
    }

    /**
     * {@inheritDoc}
     */
    public function string(string $name, string $default = ''): string
    {
        $option = $this->getOption($name);

        if ($option !== null && !is_scalar($option)) {
            $message = sprintf("Can't return non scalar option '%s' as string.", $name);
            throw new RuntimeException($message);
        }

        return $option === null ? $default : (string) $option;
    }

    /**
     * {@inheritDoc}
     */
    public function int(string $name, int $default = 0): int
    {
        $option = $this->getOption($name);

        if ($option !== null && !is_scalar($option)) {
            $message = sprintf("Can't return non scalar option '%s' as int.", $name);
            throw new RuntimeException($message);
        }

        return $option === null ? $default : (int) $option;
    }

    /**
     * {@inheritDoc}
     */
    public function bool(string $name, bool $default = false): bool
    {
        $option = $this->getOption($name);

        if ($option !== null && !is_scalar($option)) {
            $message = sprintf("Can't return non scalar option '%s' as bool.", $name);
            throw new RuntimeException($message);
        }

        return $option === null ? $default : (bool) $option;
    }

    /**
     * {@inheritDoc}
     */
    public function array(string $name, array $default = []): array
    {
        $option = $this->getOption($name);

        if ($option !== null && !is_array($option)) {
            $message = sprintf("Can't return non array option '%s' as array.", $name);
            throw new RuntimeException($message);
        }

        return $option === null ? $default : $option;
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
        $unifiedName = $this->unifyOptionName($name);

        return $this->options[$unifiedName] ?? null;
    }

    /**
     * Converts option name to internal option name format.
     *
     * @param string $name
     *
     * @return string
     */
    private function unifyOptionName(string $name): string
    {
        return strtolower(trim($name));
    }
}
