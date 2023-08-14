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
        $reader = $this->getMockBuilder(SourceReader::class)->getMock();

        $this->expectException(\InvalidArgumentException::class);
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

        $builder = new ConfigBagBuilderBasic([$reader, $reader1]);
        $builder->loadSource('array', $options);
        $bag = $builder->build();

        $this->assertSame('test value 1', $bag->string('test.test_1'));
    }

    public function testLoadUnsupportedTypeException(): void
    {
        $reader = $this->getMockBuilder(SourceReader::class)->getMock();
        $reader->method('supports')->willReturn(false);

        $reader1 = $this->getMockBuilder(SourceReader::class)->getMock();
        $reader1->method('supports')->willReturn(false);

        $builder = new ConfigBagBuilderBasic([$reader, $reader1]);

        $this->expectException(\InvalidArgumentException::class);
        $builder->loadSource('array', []);
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

        $this->assertSame('test value 1', $bag->string('test.test_1'));
    }
}
