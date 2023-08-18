<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag;

use Marvin255\DataGetterHelper\DataGetterProxy;

/**
 * Config builder that uses array of source readers to load data.
 *
 * @internal
 */
final class ConfigBagBuilderBasic implements ConfigBagBuilder
{
    /**
     * @var SourceReader[]
     */
    private readonly array $readers;

    private array $options = [];

    public function __construct(iterable $readers = null)
    {
        if ($readers === null) {
            $selectedReaders = [
                new SourceReaderArray(),
                new SourceReaderPhpFile(),
                new SourceReaderJsonFile(),
            ];
        } else {
            $selectedReaders = [];
            foreach ($readers as $reader) {
                if (!($reader instanceof SourceReader)) {
                    throw new \InvalidArgumentException(
                        'Source reader must be unstance of ' . SourceReader::class
                    );
                }
                $selectedReaders[] = $reader;
            }
        }
        $this->readers = $selectedReaders;
    }

    /**
     * {@inheritDoc}
     */
    public function loadSource(string $sourceType, mixed $source): ConfigBagBuilder
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
            throw new \InvalidArgumentException(
                "Config source type {$sourceType} is unsupported"
            );
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function build(): DataGetterProxy
    {
        $bag = DataGetterProxy::wrap($this->options);
        $this->options = [];

        return $bag;
    }
}
