<?php

declare(strict_types=1);

namespace Marvin255\ConfigBag\Tests;

use Marvin255\ConfigBag\DataAccessHelper;
use stdClass;

/**
 * @internal
 */
class DataAccessHelperTest extends BaseCase
{
    /**
     * @param string $path
     * @param mixed  $data
     * @param mixed  $result
     *
     * @dataProvider provideGetData
     */
    public function testGet(string $path, $data, $result): void
    {
        $value = DataAccessHelper::get($path, $data);

        $this->assertSame($value, $result);
    }

    public function provideGetData(): array
    {
        $object = new stdClass();
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
