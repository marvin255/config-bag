<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag\Tests;

use Marvin255\ConfigBag\DataAccessHelper;

/**
 * @internal
 */
final class DataAccessHelperTest extends BaseCase
{
    /**
     * @dataProvider provideGetData
     */
    public function testGet(string $path, mixed $data, mixed $result): void
    {
        $value = DataAccessHelper::get($path, $data);

        $this->assertSame($value, $result);
    }

    public static function provideGetData(): array
    {
        $object = new \stdClass();
        $object->test = 'test value object';

        return [
            [
                'test',
                [
                    'test' => 'test value 0',
                ],
                'test value 0',
            ],
            [
                'test.test_2.test_3',
                [
                    'test' => [
                        'test_2' => [
                            'test_3' => 'test value 1',
                        ],
                    ],
                ],
                'test value 1',
            ],
            [
                'test_2',
                [
                    'test' => 'test value',
                ],
                null,
            ],
            [
                'test',
                $object,
                $object->test,
            ],
            [
                'test_object.test',
                [
                    'test_object' => $object,
                ],
                $object->test,
            ],
            [
                'test_2',
                $object,
                null,
            ],
        ];
    }
}
