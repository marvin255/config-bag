<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag\Tests;

use Marvin255\ConfigBag\ConfigBagBuilderBasic;
use Marvin255\ConfigBag\SourceReader;
use Marvin255\ConfigBag\SourceReaderArray;

/**
 * @internal
 */
final class ConfigBagBuilderBasicTest extends BaseCase
{
    public function testConstructException(): void
    {
        $exceptionMessage = 'Source reader must be unstance of ' . SourceReader::class;
        $reader = $this->getMockBuilder(SourceReader::class)->getMock();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($exceptionMessage);
        new ConfigBagBuilderBasic(
            [
                $reader,
                'test',
            ]
        );
    }

    public function testBuild(): void
    {
        $options = [
            'test' => [
                'test_1' => 'test value 1',
            ],
        ];

        $reader = $this->getMockBuilder(SourceReader::class)->getMock();
        $reader->method('supports')->willReturn(false);
        $reader->expects($this->never())->method('read');

        $reader1 = $this->getMockBuilder(SourceReader::class)->getMock();
        $reader1->method('supports')->willReturn(true);
        $reader1->expects($this->once())->method('read')->willReturnArgument(1);

        $builder = new ConfigBagBuilderBasic(
            [
                $reader,
                $reader1,
            ]
        );
        $builder->loadSource('array', $options);
        $bag = $builder->build();
        $res = $bag->string('test.test_1');

        $this->assertSame('test value 1', $res);
    }

    public function testBuildMultipleSources(): void
    {
        $options = ['test' => 'test'];
        $options1 = ['test1' => 'test 1'];

        $reader = $this->getMockBuilder(SourceReader::class)->getMock();
        $reader->method('supports')->willReturnCallback(
            fn (string $t, mixed $p): bool => $t === 'array' && $p === $options
        );
        $reader->expects($this->once())->method('read')->willReturnArgument(1);

        $reader1 = $this->getMockBuilder(SourceReader::class)->getMock();
        $reader1->method('supports')->willReturnCallback(
            fn (string $t, mixed $p): bool => $t === 'array' && $p === $options1
        );
        $reader1->expects($this->once())->method('read')->willReturnArgument(1);

        $builder = new ConfigBagBuilderBasic(
            [
                $reader,
                $reader1,
            ]
        );
        $builder->loadSource('array', $options);
        $builder->loadSource('array', $options1);
        $bag = $builder->build();
        $res = $bag->string('test');
        $res1 = $bag->string('test1');

        $this->assertSame('test', $res);
        $this->assertSame('test 1', $res1);
    }

    public function testLoadUnsupportedTypeException(): void
    {
        $sourceType = 'array';
        $exceptionMessage = "Config source type {$sourceType} is unsupported";

        $reader = $this->getMockBuilder(SourceReader::class)->getMock();
        $reader->method('supports')->willReturn(false);

        $reader1 = $this->getMockBuilder(SourceReader::class)->getMock();
        $reader1->method('supports')->willReturn(false);

        $builder = new ConfigBagBuilderBasic(
            [
                $reader,
                $reader1,
            ]
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($exceptionMessage);
        $builder->loadSource($sourceType, []);
    }

    public function testBuildWithDefaultReaders(): void
    {
        $options = [
            'test' => [
                'test_1' => 'test value 1',
            ],
        ];

        $builder = new ConfigBagBuilderBasic();
        $builder->loadSource(SourceReaderArray::SOURCE_TYPE_ARRAY, $options);
        $bag = $builder->build();
        $res = $bag->string('test.test_1');

        $this->assertSame('test value 1', $res);
    }
}
