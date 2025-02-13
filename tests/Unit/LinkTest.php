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
use Feskol\Tests\fixtures\TranslatableMessage;
use PHPUnit\Framework\TestCase;

class LinkTest extends TestCase
{
    public function testTitleAsString(): void
    {
        $link = new Link();
        $link->setTitle('Title');

        $this->assertSame('Title', $link->getTitle());
        $this->assertTrue(is_string($link->getTitle()));
    }

    public function testTitleAsStringableClass(): void
    {
        $link = new Link();
        $link->setTitle(new TranslatableMessage('Title'));

        $this->assertNotSame('Title', $link->getTitle());
        $this->assertInstanceOf(TranslatableMessage::class, $link->getTitle());
        $this->assertSame('Title', (string)$link->getTitle());
    }

    public function testActiveStatusPropagationWithAddChild(): void
    {
        $mainLink = new Link();
        $this->assertFalse($mainLink->isActive());

        $childLink = new Link();
        $mainLink->addChild($childLink);
        $this->assertFalse($childLink->isActive());

        $activeChildLink = new Link();
        $activeChildLink->setIsActive(true);
        $this->assertTrue($activeChildLink->isActive());

        $this->assertSame(0, $mainLink->getActiveChildrenCount());
        $this->assertSame(0, $childLink->getActiveChildrenCount());
        $this->assertFalse($mainLink->hasActiveChildren());
        $this->assertFalse($childLink->hasActiveChildren());

        $childLink->addChild($activeChildLink);

        $this->assertSame(1, $mainLink->getActiveChildrenCount());
        $this->assertSame(1, $childLink->getActiveChildrenCount());

        $this->assertFalse($mainLink->isActive());
        $this->assertFalse($childLink->isActive());
        $this->assertTrue($mainLink->hasActiveChildren());
        $this->assertTrue($childLink->hasActiveChildren());

        $this->assertTrue($activeChildLink->isActive());
    }

    public function testActiveStatusPropagationWithoutSetChildren(): void
    {
        $mainLink = new Link();
        $this->assertFalse($mainLink->isActive());

        $childLink = new Link();
        $mainLink->addChild($childLink);
        $this->assertFalse($childLink->isActive());

        $activeChildLink = new Link();
        $activeChildLink->setIsActive(true);
        $childLink->addChild($activeChildLink);

        $this->assertTrue($activeChildLink->isActive());
        $this->assertFalse($childLink->isActive());
        $this->assertTrue($childLink->hasActiveChildren());

        $this->assertSame(1, $mainLink->getActiveChildrenCount());
        $this->assertSame(1, $childLink->getActiveChildrenCount());

        $childLink->setChildren([$activeChildLink]);

        $this->assertSame(1, $mainLink->getActiveChildrenCount());
        $this->assertSame(1, $childLink->getActiveChildrenCount());

        $this->assertFalse($mainLink->isActive());
        $this->assertTrue($mainLink->hasActiveChildren());
    }

    public function testActiveStatusUpdatePropagation(): void
    {
        $lastChildLink = new Link();
        $childLink = (new Link())->addChild($lastChildLink);
        $mainLink = (new Link())->addChild($childLink);

        $this->assertFalse($mainLink->isActive());

        $this->assertSame(0, $mainLink->getActiveChildrenCount());
        $this->assertSame(0, $childLink->getActiveChildrenCount());

        $lastChildLink->setIsActive(true);

        $this->assertSame(1, $mainLink->getActiveChildrenCount());
        $this->assertSame(1, $childLink->getActiveChildrenCount());

        $this->assertFalse($mainLink->isActive());
        $this->assertFalse($childLink->isActive());
        $this->assertTrue($mainLink->hasActiveChildren());
        $this->assertTrue($childLink->hasActiveChildren());

        $this->assertTrue($lastChildLink->isActive());
    }

    public function testInActiveStatusPropagationWithRemoveChild(): void
    {
        $lastChildLink = (new Link())->setIsActive(true);
        $childLink = (new Link())->addChild($lastChildLink);
        $mainLink = (new Link())->addChild($childLink);

        $this->assertFalse($mainLink->isActive());
        $this->assertFalse($childLink->isActive());
        $this->assertTrue($lastChildLink->isActive());

        $this->assertTrue($mainLink->hasActiveChildren());
        $this->assertTrue($childLink->hasActiveChildren());
        $this->assertFalse($lastChildLink->hasActiveChildren());

        $this->assertSame(1, $mainLink->getActiveChildrenCount());
        $this->assertSame(1, $childLink->getActiveChildrenCount());

        $childLink->removeChild($lastChildLink);

        $this->assertSame(0, $mainLink->getActiveChildrenCount());
        $this->assertSame(0, $childLink->getActiveChildrenCount());

        $this->assertFalse($childLink->isActive());
        $this->assertFalse($mainLink->isActive());
        $this->assertFalse($childLink->hasActiveChildren());
        $this->assertFalse($mainLink->hasActiveChildren());
    }

    public function testInActiveStatusPropagation(): void
    {
        $lastChildLink = (new Link())->setIsActive(true);
        $childLink = (new Link())->addChild($lastChildLink);
        $mainLink = (new Link())->addChild($childLink);

        $this->assertTrue($mainLink->hasActiveChildren());
        $this->assertTrue($childLink->hasActiveChildren());
        $this->assertTrue($lastChildLink->isActive());

        $this->assertSame(1, $mainLink->getActiveChildrenCount());
        $this->assertSame(1, $childLink->getActiveChildrenCount());

        $lastChildLink->setIsActive(false);

        $this->assertSame(0, $mainLink->getActiveChildrenCount());
        $this->assertSame(0, $childLink->getActiveChildrenCount());

        $this->assertFalse($lastChildLink->isActive());
        $this->assertFalse($childLink->hasActiveChildren());
        $this->assertFalse($mainLink->hasActiveChildren());
    }

    public function testCorrectActiveChildrenCountWithMultipleChildren(): void
    {
        $mainLink = new Link();

        $firstLink = new Link();
        $secondLink = new Link();
        $mainLink->setChildren([$firstLink, $secondLink]);

        $firstLinkChild1 = (new Link())->setIsActive(true);
        $firstLinkChild2 = (new Link())->setIsActive(true);
        $firstLinkChild3 = (new Link())->setIsActive(true);
        $firstLink->setChildren([
            $firstLinkChild1,
            $firstLinkChild2,
            $firstLinkChild3,
        ]);

        $secondLinkChild1 = new Link();
        $secondLinkChild2 = (new Link())->setisActive(true);
        $secondLinkChild3 = new Link();
        $secondLink->setChildren([
            $secondLinkChild1,
            $secondLinkChild2,
            $secondLinkChild3,
        ]);

        $this->assertSame(2, $mainLink->getActiveChildrenCount());
        $this->assertSame(3, $firstLink->getActiveChildrenCount());
        $this->assertSame(1, $secondLink->getActiveChildrenCount());
    }

    public function testCorrectActiveChildrenCountWithMultipleChildrenOnAddChild(): void
    {
        $mainLink = new Link();

        $firstLink = new Link();
        $secondLink = new Link();
        $mainLink->setChildren([$firstLink, $secondLink]);

        $firstLinkChild1 = (new Link())->setIsActive(true);
        $firstLinkChild2 = (new Link())->setIsActive(true);
        $firstLinkChild3 = (new Link())->setIsActive(true);
        $firstLink->setChildren([
            $firstLinkChild1,
            $firstLinkChild2,
            $firstLinkChild3,
        ]);

        $secondLinkChild1 = new Link();
        $secondLinkChild2 = (new Link())->setisActive(true);
        $secondLinkChild3 = new Link();
        $secondLink->setChildren([
            $secondLinkChild1,
            $secondLinkChild2,
            $secondLinkChild3,
        ]);

        // now we add more links

        $firstLinkAdditionalInactiveChild = new Link();
        $firstLinkAdditionalActiveChild = (new Link())->setIsActive(true);
        $firstLink
            ->addChild($firstLinkAdditionalInactiveChild)
            ->addChild($firstLinkAdditionalActiveChild);

        $secondLinkAdditionalInactiveChild = new Link();
        $secondLinkAdditionalActiveChild1 = (new Link())->setIsActive(true);
        $secondLinkAdditionalActiveChild2 = (new Link())->setIsActive(true);
        $secondLink
            ->addChild($secondLinkAdditionalInactiveChild)
            ->addChild($secondLinkAdditionalActiveChild1)
            ->addChild($secondLinkAdditionalActiveChild2);

        $this->assertSame(2, $mainLink->getActiveChildrenCount());
        $this->assertSame(4, $firstLink->getActiveChildrenCount());
        $this->assertSame(3, $secondLink->getActiveChildrenCount());
    }

    public function testCorrectActiveChildrenCountWithMultipleChildrenOnRemoveChild(): void
    {
        $mainLink = new Link();

        $firstLink = new Link();
        $secondLink = new Link();
        $mainLink->setChildren([$firstLink, $secondLink]);

        $firstLinkChild1 = (new Link())->setIsActive(true);
        $firstLinkChild2 = (new Link())->setIsActive(true);
        $firstLinkChild3 = (new Link())->setIsActive(true);
        $firstLinkChild4 = new Link();
        $firstLinkChild5 = (new Link())->setIsActive(true);
        $firstLink->setChildren([
            $firstLinkChild1,
            $firstLinkChild2,
            $firstLinkChild3,
            $firstLinkChild4,
            $firstLinkChild5,
        ]);

        $secondLinkChild1 = new Link();
        $secondLinkChild2 = (new Link())->setisActive(true);
        $secondLinkChild3 = new Link();
        $secondLinkChild4 = new Link();
        $secondLinkChild5 = (new Link())->setisActive(true);
        $secondLinkChild6 = (new Link())->setisActive(true);
        $secondLink->setChildren([
            $secondLinkChild1,
            $secondLinkChild2,
            $secondLinkChild3,
            $secondLinkChild4,
            $secondLinkChild5,
            $secondLinkChild6,
        ]);

        $this->assertSame(2, $mainLink->getActiveChildrenCount());
        $this->assertSame(4, $firstLink->getActiveChildrenCount());
        $this->assertSame(3, $secondLink->getActiveChildrenCount());

        // now we remove some active-links

        $firstLink
            ->removeChild($firstLinkChild1)
            ->removeChild($firstLinkChild3);

        $secondLink
            ->removeChild($secondLinkChild2)
            ->removeChild($secondLinkChild5)
            ->removeChild($secondLinkChild6);

        $this->assertSame(1, $mainLink->getActiveChildrenCount());
        $this->assertSame(2, $firstLink->getActiveChildrenCount());
        $this->assertSame(0, $secondLink->getActiveChildrenCount());
    }

    public function testCorrectActiveChildrenCountWithMultipleChildrenOnUpdate(): void
    {
        $mainLink = new Link();

        $firstLink = new Link();
        $secondLink = new Link();
        $mainLink->setChildren([$firstLink, $secondLink]);

        $firstLinkChild1 = (new Link())->setIsActive(true);
        $firstLinkChild2 = (new Link())->setIsActive(true);
        $firstLinkChild3 = (new Link())->setIsActive(true);
        $firstLinkChild4 = new Link();
        $firstLinkChild5 = new Link();
        $firstLink->setChildren([
            $firstLinkChild1,
            $firstLinkChild2,
            $firstLinkChild3,
            $firstLinkChild4,
            $firstLinkChild5,
        ]);

        $secondLinkChild1 = new Link();
        $secondLinkChild2 = (new Link())->setisActive(true);
        $secondLinkChild3 = new Link();
        $secondLinkChild4 = new Link();
        $secondLinkChild5 = new Link();
        $secondLink->setChildren([
            $secondLinkChild1,
            $secondLinkChild2,
            $secondLinkChild3,
            $secondLinkChild4,
            $secondLinkChild5,
        ]);

        $this->assertSame(2, $mainLink->getActiveChildrenCount());
        $this->assertSame(3, $firstLink->getActiveChildrenCount());
        $this->assertSame(1, $secondLink->getActiveChildrenCount());


        $firstLinkChild1->setIsActive(false);
        $firstLinkChild2->setIsActive(false);

        $secondLinkChild3->setIsActive(true);
        $secondLinkChild4->setIsActive(true);
        $secondLinkChild5->setIsActive(true);

        $this->assertSame(2, $mainLink->getActiveChildrenCount());
        $this->assertSame(1, $firstLink->getActiveChildrenCount());
        $this->assertSame(4, $secondLink->getActiveChildrenCount());
    }

    public function testCorrectActiveChildrenCountWithMultipleChildrenOnRemoveTopLink(): void
    {
        $mainLink = new Link();

        $firstLink = new Link();
        $secondLink = new Link();
        $thirdLink = new Link();
        $mainLink->setChildren([$firstLink, $secondLink, $thirdLink]);

        $firstLinkChild1 = (new Link())->setIsActive(true);
        $firstLinkChild2 = (new Link())->setIsActive(true);
        $firstLinkChild3 = new Link();
        $firstLink->setChildren([$firstLinkChild1, $firstLinkChild2, $firstLinkChild3]);

        $secondLinkChild1 = new Link();
        $secondLinkChild2 = (new Link())->setisActive(true);
        $secondLinkChild3 = new Link();
        $secondLink->setChildren([$secondLinkChild1, $secondLinkChild2, $secondLinkChild3]);

        $thirdLinkChild1 = (new Link())->setisActive(true);
        $thirdLinkChild2 = (new Link())->setisActive(true);
        $thirdLinkChild3 = (new Link())->setisActive(true);
        $thirdLink->setChildren([$thirdLinkChild1, $thirdLinkChild2, $thirdLinkChild3]);

        $this->assertSame(3, $mainLink->getActiveChildrenCount());
        $this->assertSame(2, $firstLink->getActiveChildrenCount());
        $this->assertSame(1, $secondLink->getActiveChildrenCount());
        $this->assertSame(3, $thirdLink->getActiveChildrenCount());

        $mainLink->removeChild($firstLink);
        $mainLink->removeChild($thirdLink);

        $this->assertSame(1, $mainLink->getActiveChildrenCount());
        $this->assertSame(1, $secondLink->getActiveChildrenCount());
    }

    public function testResettingChildrenCorrectParentActiveStatus(): void
    {
        $mainLink = new Link();

        $this->assertSame(0, $mainLink->getActiveChildrenCount());

        $firstLink = (new Link())->setIsActive(true);
        $secondLink = (new Link())->setIsActive(true);
        $mainLink->setChildren([$firstLink, $secondLink]);

        $this->assertSame(2, $mainLink->getActiveChildrenCount());
        $this->assertSame(0, $firstLink->getActiveChildrenCount());
        $this->assertSame(0, $secondLink->getActiveChildrenCount());

        $firstLinkChild1 = (new Link())->setIsActive(true);
        $firstLinkChild2 = (new Link())->setIsActive(true);
        $firstLinkChild3 = new Link();
        $firstLink->setChildren([$firstLinkChild1, $firstLinkChild2, $firstLinkChild3]);

        $this->assertSame(2, $mainLink->getActiveChildrenCount());
        $this->assertSame(2, $firstLink->getActiveChildrenCount());
        $this->assertSame(0, $secondLink->getActiveChildrenCount());

        $secondLinkChild1 = new Link();
        $secondLinkChild2 = (new Link())->setisActive(true);
        $secondLinkChild3 = new Link();
        $secondLink->setChildren([$secondLinkChild1, $secondLinkChild2, $secondLinkChild3]);

        $this->assertSame(2, $mainLink->getActiveChildrenCount());
        $this->assertSame(2, $firstLink->getActiveChildrenCount());
        $this->assertSame(1, $secondLink->getActiveChildrenCount());

        $updatedFirstLinkChild1 = new Link();
        $updatedFirstLinkChild2 = new Link();
        $updatedFirstLinkChild3 = (new Link())->setIsActive(true);
        $firstLink->setChildren([$updatedFirstLinkChild1, $updatedFirstLinkChild2, $updatedFirstLinkChild3]);

        $updatedSecondLinkChild1 = new Link();
        $updatedSecondLinkChild2 = new Link();
        $updatedSecondLinkChild3 = new Link();
        $secondLink->setChildren([$updatedSecondLinkChild1, $updatedSecondLinkChild2, $updatedSecondLinkChild3]);

        $this->assertSame(2, $mainLink->getActiveChildrenCount());
        $this->assertSame(1, $firstLink->getActiveChildrenCount());
        $this->assertSame(0, $secondLink->getActiveChildrenCount());
    }

    public function testRemoveChildWithActiveChildren(): void
    {
        $mainLink = new Link();

        $this->assertSame(0, $mainLink->getActiveChildrenCount());

        $firstLink = (new Link())->setIsActive(true);
        $secondLink = (new Link())->setIsActive(true);
        $mainLink->setChildren([$firstLink, $secondLink]);

        $this->assertSame(2, $mainLink->getActiveChildrenCount());
        $this->assertSame(0, $firstLink->getActiveChildrenCount());
        $this->assertSame(0, $secondLink->getActiveChildrenCount());

        $firstLinkChild1 = (new Link())->setIsActive(true);
        $firstLinkChild2 = (new Link())->setIsActive(true);
        $firstLinkChild3 = new Link();
        $firstLink->setChildren([$firstLinkChild1, $firstLinkChild2, $firstLinkChild3]);

        $secondLinkChild1 = new Link();
        $secondLinkChild2 = (new Link())->setisActive(true);
        $secondLinkChild3 = (new Link())->setisActive(true);
        $secondLink->setChildren([$secondLinkChild1, $secondLinkChild2, $secondLinkChild3]);

        $this->assertSame(2, $mainLink->getActiveChildrenCount());
        $this->assertSame(2, $firstLink->getActiveChildrenCount());
        $this->assertSame(2, $secondLink->getActiveChildrenCount());

        $mainLink->removeChild($firstLink);

        $this->assertSame(1, $mainLink->getActiveChildrenCount());
        $this->assertSame(2, $secondLink->getActiveChildrenCount());
    }

    public function testParentAssignment(): void
    {
        $mainLink = new Link();

        $firstLink = new Link();
        $secondLink = new Link();
        $mainLink->setChildren([$firstLink, $secondLink]);

        $firstLinkChild1 = new Link();
        $firstLinkChild2 = new Link();
        $firstLinkChild3 = new Link();
        $firstLink
            ->addChild($firstLinkChild1)
            ->addChild($firstLinkChild2)
            ->addChild($firstLinkChild3);

        $secondLinkChild1 = new Link();
        $secondLinkChild2 = new Link();
        $secondLinkChild3 = new Link();
        $secondLink->setChildren([$secondLinkChild1, $secondLinkChild2, $secondLinkChild3]);

        $this->assertSame($mainLink, $firstLink->getParent());
        $this->assertSame($mainLink, $secondLink->getParent());

        $this->assertSame($firstLink, $firstLinkChild1->getParent());
        $this->assertSame($firstLink, $firstLinkChild2->getParent());
        $this->assertSame($firstLink, $firstLinkChild3->getParent());

        $this->assertSame($secondLink, $secondLinkChild1->getParent());
        $this->assertSame($secondLink, $secondLinkChild2->getParent());
        $this->assertSame($secondLink, $secondLinkChild3->getParent());
    }

    public function testParentRemoval(): void
    {
        $mainLink = new Link();

        $firstLink = new Link();
        $secondLink = new Link();
        $thirdLink = new Link();
        $mainLink->setChildren([$firstLink, $secondLink, $thirdLink]);

        $this->assertSame($mainLink, $firstLink->getParent());
        $this->assertSame($mainLink, $secondLink->getParent());
        $this->assertSame($mainLink, $thirdLink->getParent());

        $mainLink->removeChild($firstLink);

        $this->assertNull($firstLink->getParent());
        $this->assertSame($mainLink, $secondLink->getParent());
        $this->assertSame($mainLink, $thirdLink->getParent());

        $mainLink->setChildren([]);

        $this->assertNull($secondLink->getParent());
        $this->assertNull($thirdLink->getParent());
    }
}
