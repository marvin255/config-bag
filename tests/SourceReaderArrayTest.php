<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag\Tests;

use Marvin255\ConfigBag\SourceReaderArray;

/**
 * @internal
 */
final class SourceReaderArrayTest extends BaseCase
{
    public function testSupports(): void
    {
        $reader = new SourceReaderArray();
        $isSupport = $reader->supports(SourceReaderArray::SOURCE_TYPE_ARRAY, []);

        $this->assertTrue($isSupport);
    }

    public function testNotSupports(): void
    {
        $reader = new SourceReaderArray();
        $isSupport = $reader->supports('test', []);

        $this->assertFalse($isSupport);
    }

    public function testRead(): void
    {
        $options = [
            'test' => 'test',
        ];

        $reader = new SourceReaderArray();
        $readedOptions = $reader->read(SourceReaderArray::SOURCE_TYPE_ARRAY, $options);

        $this->assertSame($options, $readedOptions);
    }

    public function testReadException(): void
    {
        $reader = new SourceReaderArray();

        $this->expectException(\InvalidArgumentException::class);
        $reader->read(SourceReaderArray::SOURCE_TYPE_ARRAY, 'test');
    }
}
