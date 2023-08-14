<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag\Tests;

use Marvin255\ConfigBag\ConfigBagArray;

/**
 * @internal
 */
final class ConfigBagArrayTest extends BaseCase
{
    public function testHas(): void
    {
        $options = [
            'test_name' => 'test_value',
        ];

        $bag = new ConfigBagArray($options);
        $has = $bag->has('test_name');

        $this->assertTrue($has);
    }

    public function testHasNot(): void
    {
        $options = [
            'test_name' => 'test_value',
        ];

        $bag = new ConfigBagArray($options);
        $has = $bag->has('test_name_1');

        $this->assertFalse($has);
    }

    public function testHasMultilevel(): void
    {
        $options = [
            'test_name' => [
                'test_name_1' => 'test_value',
            ],
        ];

        $bag = new ConfigBagArray($options);
        $has = $bag->has('test_name.test_name_1');

        $this->assertTrue($has);
    }

    public function testHasNotMultilevel(): void
    {
        $options = [
            'test_name' => [
                'test_name_1' => 'test_value',
            ],
        ];

        $bag = new ConfigBagArray($options);
        $has = $bag->has('test_name.test_name_2');

        $this->assertFalse($has);
    }

    public function testString(): void
    {
        $options = [
            'test_name' => 'test_value',
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->string('test_name');

        $this->assertSame('test_value', $option);
    }

    public function testStringMultilevel(): void
    {
        $options = [
            'test_name' => [
                'test_name_1' => 'test_value',
            ],
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->string('test_name.test_name_1');

        $this->assertSame('test_value', $option);
    }

    public function testStringDefault(): void
    {
        $options = [
            'test_name' => 'test_value',
        ];
        $default = 'default_value';

        $bag = new ConfigBagArray($options);
        $option = $bag->string('test_name_1', $default);

        $this->assertSame($default, $option);
    }

    public function testStringCast(): void
    {
        $options = [
            'test_name' => 0,
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->string('test_name');

        $this->assertSame('0', $option);
    }

    public function testStringConvertException(): void
    {
        $options = [
            'test_name' => [],
        ];

        $bag = new ConfigBagArray($options);

        $this->expectException(\RuntimeException::class);
        $bag->string('test_name');
    }

    public function testStringRequired(): void
    {
        $options = [
            'test_name' => 'test_value',
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->stringRequired('test_name');

        $this->assertSame('test_value', $option);
    }

    public function testStringRequiredException(): void
    {
        $options = [];

        $bag = new ConfigBagArray($options);

        $this->expectException(\RuntimeException::class);
        $bag->stringRequired('test_name');
    }

    public function testInt(): void
    {
        $options = [
            'test_name' => 123,
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->int('test_name');

        $this->assertSame(123, $option);
    }

    public function testIntMultilevel(): void
    {
        $options = [
            'test_name' => [
                'test_name_1' => 123,
            ],
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->int('test_name.test_name_1');

        $this->assertSame(123, $option);
    }

    public function testIntDefault(): void
    {
        $options = [
            'test_name' => 'test_value',
        ];
        $default = 456;

        $bag = new ConfigBagArray($options);
        $option = $bag->int('test_name_1', $default);

        $this->assertSame($default, $option);
    }

    public function testIntCast(): void
    {
        $options = [
            'test_name' => '123',
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->int('test_name');

        $this->assertSame(123, $option);
    }

    public function testIntConvertException(): void
    {
        $options = [
            'test_name' => [],
        ];

        $bag = new ConfigBagArray($options);

        $this->expectException(\RuntimeException::class);
        $bag->int('test_name');
    }

    public function testIntRequired(): void
    {
        $options = [
            'test_name' => 123,
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->intRequired('test_name');

        $this->assertSame(123, $option);
    }

    public function testIntRequiredException(): void
    {
        $options = [];

        $bag = new ConfigBagArray($options);

        $this->expectException(\RuntimeException::class);
        $bag->intRequired('test_name');
    }

    public function testFloat(): void
    {
        $options = [
            'test_name' => 123.123,
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->float('test_name');

        $this->assertSame(123.123, $option);
    }

    public function testFloatMultilevel(): void
    {
        $options = [
            'test_name' => [
                'test_name_1' => 123.123,
            ],
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->float('test_name.test_name_1');

        $this->assertSame(123.123, $option);
    }

    public function testFloatDefault(): void
    {
        $options = [
            'test_name' => 'test_value',
        ];
        $default = 456.456;

        $bag = new ConfigBagArray($options);
        $option = $bag->float('test_name_1', $default);

        $this->assertSame($default, $option);
    }

    public function testFloatCast(): void
    {
        $options = [
            'test_name' => '123.123',
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->float('test_name');

        $this->assertSame(123.123, $option);
    }

    public function testFloatConvertException(): void
    {
        $options = [
            'test_name' => [],
        ];

        $bag = new ConfigBagArray($options);

        $this->expectException(\RuntimeException::class);
        $bag->float('test_name');
    }

    public function testFloatRequired(): void
    {
        $options = [
            'test_name' => 123.456,
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->floatRequired('test_name');

        $this->assertSame(123.456, $option);
    }

    public function testFloatRequiredException(): void
    {
        $options = [];

        $bag = new ConfigBagArray($options);

        $this->expectException(\RuntimeException::class);
        $bag->floatRequired('test_name');
    }

    public function testBool(): void
    {
        $options = [
            'test_name' => true,
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->bool('test_name');

        $this->assertTrue($option);
    }

    public function testBoolMultilevel(): void
    {
        $options = [
            'test_name' => [
                'test_name_1' => true,
            ],
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->bool('test_name.test_name_1');

        $this->assertTrue($option);
    }

    public function testBoolDefault(): void
    {
        $options = [
            'test_name' => 'test_value',
        ];
        $default = true;

        $bag = new ConfigBagArray($options);
        $option = $bag->bool('test_name_1', $default);

        $this->assertSame($default, $option);
    }

    public function testBoolCast(): void
    {
        $options = [
            'test_name' => 1,
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->bool('test_name');

        $this->assertTrue($option);
    }

    public function testBoolConvertException(): void
    {
        $options = [
            'test_name' => [],
        ];

        $bag = new ConfigBagArray($options);

        $this->expectException(\RuntimeException::class);
        $bag->bool('test_name');
    }

    public function testBoolRequired(): void
    {
        $options = [
            'test_name' => true,
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->boolRequired('test_name');

        $this->assertTrue($option);
    }

    public function testBoolRequiredException(): void
    {
        $options = [];

        $bag = new ConfigBagArray($options);

        $this->expectException(\RuntimeException::class);
        $bag->boolRequired('test_name');
    }

    public function testArray(): void
    {
        $options = [
            'test_name' => [123],
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->array('test_name');

        $this->assertSame([123], $option);
    }

    public function testArrayMultilevel(): void
    {
        $options = [
            'test_name' => [
                'test_name_1' => [123],
            ],
        ];

        $bag = new ConfigBagArray($options);
        $option = $bag->array('test_name.test_name_1');

        $this->assertSame([123], $option);
    }

    public function testArrayDefault(): void
    {
        $options = [
            'test_name' => 'test_value',
        ];
        $default = [123];

        $bag = new ConfigBagArray($options);
        $option = $bag->array('test_name_1', $default);

        $this->assertSame([123], $option);
    }

    public function testArrayConvertException(): void
    {
        $options = [
            'test_name' => 123,
        ];

        $bag = new ConfigBagArray($options);

        $this->expectException(\RuntimeException::class);
        $bag->array('test_name');
    }
}
