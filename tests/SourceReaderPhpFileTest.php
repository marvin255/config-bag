<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag\Tests;

use InvalidArgumentException;
use Marvin255\ConfigBag\SourceReaderPhpFile;

/**
 * @internal
 */
class SourceReaderPhpFileTest extends BaseCase
{
    /**
     * @test
     */
    public function testSupports(): void
    {
        $reader = new SourceReaderPhpFile();
        $isSupport = $reader->supports(SourceReaderPhpFile::SOURCE_TYPE_PHP_FILE, 'test');

        $this->assertTrue($isSupport);
    }

    /**
     * @test
     */
    public function testNotSupports(): void
    {
        $reader = new SourceReaderPhpFile();
        $isSupport = $reader->supports('test', []);

        $this->assertFalse($isSupport);
    }

    /**
     * @test
     */
    public function testRead(): void
    {
        $file = __DIR__ . '/_fixtures/SourceReaderPhpFileTest_testRead.php';
        $options = ['test' => 'test'];

        $reader = new SourceReaderPhpFile();
        $readedOptions = $reader->read(SourceReaderPhpFile::SOURCE_TYPE_PHP_FILE, $file);

        $this->assertSame($options, $readedOptions);
    }

    /**
     * @test
     */
    public function testReadException(): void
    {
        $reader = new SourceReaderPhpFile();

        $this->expectException(InvalidArgumentException::class);
        $reader->read(SourceReaderPhpFile::SOURCE_TYPE_PHP_FILE, []);
    }

    /**
     * @test
     */
    public function testReadUnexistedFileException(): void
    {
        $reader = new SourceReaderPhpFile();

        $this->expectException(InvalidArgumentException::class);
        $reader->read(SourceReaderPhpFile::SOURCE_TYPE_PHP_FILE, '/test.php');
    }
}
