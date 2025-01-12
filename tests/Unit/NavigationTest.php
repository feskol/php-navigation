<?php
/**
 * This file is part of the php-navigation project.
 *
 * (c) Festim Kolgeci <festim.kolgei@pm.me>
 *
 * For complete copyright and license details, please refer
 * to the LICENSE file distributed with this source code.
 */

namespace Feskol\Tests\Unit;

use Feskol\Navigation\Link;
use Feskol\Navigation\Navigation;
use Feskol\Tests\fixtures\TranslatableMessage;
use PHPUnit\Framework\TestCase;

class NavigationTest extends TestCase
{
    public function testTitleAsString(): void
    {
        $navigation = new Navigation();
        $navigation->setTitle('Title');

        $this->assertSame('Title', $navigation->getTitle());
        $this->assertTrue(is_string($navigation->getTitle()));
    }

    public function testTitleAsStringableClass(): void
    {
        $navigation = new Navigation();
        $navigation->setTitle(new TranslatableMessage('Title'));

        $this->assertNotSame('Title', $navigation->getTitle());
        $this->assertInstanceOf(TranslatableMessage::class, $navigation->getTitle());
        $this->assertSame('Title', (string)$navigation->getTitle());
    }

    public function testAddLink(): void
    {
        $navigation = new Navigation();

        $this->assertEmpty($navigation->getLinks());

        $navigation
            ->addLink(new Link())
            ->addLink(new Link())
            ->addLink(new Link());

        $this->assertCount(3, $navigation->getLinks());
    }

    public function testRemoveLink(): void
    {
        $navigation = new Navigation();

        $link1 = new Link();
        $link2 = new Link();
        $link3 = new Link();

        $navigation
            ->addLink($link1)
            ->addLink($link2)
            ->addLink($link3);

        $this->assertCount(3, $navigation->getLinks());

        $navigation->removeLink($link1);
        $this->assertCount(2, $navigation->getLinks());

        $navigation->removeLink($link2);
        $this->assertCount(1, $navigation->getLinks());

        $navigation->removeLink($link3);
        $this->assertCount(0, $navigation->getLinks());
    }
}
