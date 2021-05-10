<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag\Tests;

use InvalidArgumentException;
use Marvin255\ConfigBag\SourceReaderArray;

/**
 * @internal
 */
class SourceReaderArrayTest extends BaseCase
{
    /**
     * @test
     */
    public function testSupports(): void
    {
        $reader = new SourceReaderArray();
        $isSupport = $reader->supports(SourceReaderArray::SOURCE_TYPE_ARRAY, []);

        $this->assertTrue($isSupport);
    }

    /**
     * @test
     */
    public function testNotSupports(): void
    {
        $reader = new SourceReaderArray();
        $isSupport = $reader->supports('test', []);

        $this->assertFalse($isSupport);
    }

    /**
     * @test
     */
    public function testRead(): void
    {
        $options = ['test' => 'test'];

        $reader = new SourceReaderArray();
        $readedOptions = $reader->read(SourceReaderArray::SOURCE_TYPE_ARRAY, $options);

        $this->assertSame($options, $readedOptions);
    }

    /**
     * @test
     */
    public function testReadException(): void
    {
        $reader = new SourceReaderArray();

        $this->expectException(InvalidArgumentException::class);
        $reader->read(SourceReaderArray::SOURCE_TYPE_ARRAY, 'test');
    }
}
