<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag\Tests;

use Marvin255\ConfigBag\SourceReaderJsonFile;

/**
 * @internal
 */
final class SourceReaderJsonFileTest extends BaseCase
{
    public function testSupports(): void
    {
        $reader = new SourceReaderJsonFile();
        $isSupport = $reader->supports(SourceReaderJsonFile::SOURCE_TYPE_JSON_FILE, 'test');

        $this->assertTrue($isSupport);
    }

    public function testNotSupports(): void
    {
        $reader = new SourceReaderJsonFile();
        $isSupport = $reader->supports('test', []);

        $this->assertFalse($isSupport);
    }

    public function testRead(): void
    {
        $file = __DIR__ . '/_fixtures/SourceReaderJsonFileTest_testRead.json';
        $options = [
            'test' => 'test',
        ];

        $reader = new SourceReaderJsonFile();
        $readedOptions = $reader->read(SourceReaderJsonFile::SOURCE_TYPE_JSON_FILE, $file);

        $this->assertSame($options, $readedOptions);
    }

    public function testReadException(): void
    {
        $reader = new SourceReaderJsonFile();

        $this->expectException(\InvalidArgumentException::class);
        $reader->read(SourceReaderJsonFile::SOURCE_TYPE_JSON_FILE, []);
    }

    public function testReadUnexistedFileException(): void
    {
        $reader = new SourceReaderJsonFile();

        $this->expectException(\InvalidArgumentException::class);
        $reader->read(SourceReaderJsonFile::SOURCE_TYPE_JSON_FILE, '/test.json');
    }
}
