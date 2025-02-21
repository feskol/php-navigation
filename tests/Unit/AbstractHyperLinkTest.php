<?php
/**
 * This file is part of the php-navigation project.
 *
 * (c) Festim Kolgeci <festim.kolgei@pm.me>
 *
 * For complete copyright and license details, please refer
 * to the LICENSE file distributed with this source code.
 */

use Feskol\Tests\fixtures\HyperLink;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AbstractHyperLinkTest extends TestCase
{
    #[DataProvider('getTestData')]
    public function testHyperLinkGetterAndSetters(
        string $setter,
        mixed  $value,
        string $getter,
        mixed  $expected
    ): void
    {
        $hyperLink = new HyperLink();

        $hyperLink->$setter($value);
        $result = $hyperLink->$getter();

        $this->assertEquals(
            $expected,
            $result,
            sprintf(
                'Expected "%s" in getter "%s()" settet with setter "%s()", got "%s"',
                $expected,
                $getter,
                $setter,
                $result
            )
        );
    }

    public function testAddPing(): void
    {
        $hyperLink = new HyperLink();
        $this->assertNull($hyperLink->getPing());

        $hyperLink->addPing('https://www.example.com/trackpings');
        $this->assertEquals('https://www.example.com/trackpings', $hyperLink->getPing());

        $hyperLink->addPing('https://www.google.com/trackpings');
        $this->assertEquals(
            'https://www.example.com/trackpings https://www.google.com/trackpings',
            $hyperLink->getPing()
        );
    }

    public function testRemovePing(): void
    {
        $hyperLink = new HyperLink();
        $hyperLink->setPing('https://www.example.com/trackpings https://www.google.com/trackpings');
        $this->assertEquals(
            'https://www.example.com/trackpings https://www.google.com/trackpings',
            $hyperLink->getPing()
        );

        $hyperLink->removePing('https://www.google.com/trackpings');
        $this->assertEquals('https://www.example.com/trackpings', $hyperLink->getPing());

        $hyperLink->removePing('https://www.example.com/trackpings');

        $this->assertNull($hyperLink->getPing());
    }

    public static function getTestData(): array
    {
        return [
            ['setHref', '/test', 'getHref', '/test'],
            ['setHreflang', 'en', 'getHreflang', 'en'],
            ['setTarget', '_blank', 'getTarget', '_blank'],
            ['setRel', 'noreferrer', 'getRel', 'noreferrer'],
            ['setType', 'text/html', 'getType', 'text/html'],
            ['setReferrerPolicy', 'same-origin', 'getReferrerPolicy', 'same-origin'],
            ['setMedia', 'print and (resolution:300dpi)', 'getMedia', 'print and (resolution:300dpi)'],
            ['setPing', 'https://www.example.com/trackpings', 'getPing', 'https://www.example.com/trackpings'],
            ['setPing', 'https://www.example.com/trackpings https://www.google.com/trackpings', 'getPing', 'https://www.example.com/trackpings https://www.google.com/trackpings'],
            ['setIsDownload', true, 'isDownload', true],
        ];
    }
}
