<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag;

use InvalidArgumentException;

/**
 * Config builder that uses array of source readers to load data.
 */
class ConfigBagBuilderBasic implements ConfigBagBuilder
{
    /**
     * @var SourceReader[]
     */
    private array $readers;

    private array $options = [];

    public function __construct(?iterable $readers = null)
    {
        if ($readers === null) {
            $this->readers = [
                new SourceReaderArray(),
                new SourceReaderPhpFile(),
                new SourceReaderJsonFile(),
            ];
        } else {
            $this->readers = [];
            foreach ($readers as $reader) {
                if (!($reader instanceof SourceReader)) {
                    $message = sprintf("Source reader must be unstance of '%s'.", SourceReader::class);
                    throw new InvalidArgumentException($message);
                }
                $this->readers[] = $reader;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function loadSource(string $sourceType, $source): ConfigBagBuilder
    {
        $isSupported = false;
        foreach ($this->readers as $reader) {
            if ($reader->supports($sourceType, $source)) {
                $readData = $reader->read($sourceType, $source);
                $this->options = array_merge($this->options, $readData);
                $isSupported = true;
                break;
            }
        }

        if (!$isSupported) {
            $message = sprintf("Config source type '%s' is unsupported.", $sourceType);
            throw new InvalidArgumentException($message);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function build(): ConfigBag
    {
        $bag = new ConfigBagArray($this->options);
        $this->options = [];

        return $bag;
    }
}
