<?php
/**
 * This file is part of the php-navigation project.
 *
 * (c) Festim Kolgeci <festim.kolgei@pm.me>
 *
 * For complete copyright and license details, please refer
 * to the LICENSE file distributed with this source code.
 */

namespace Feskol\Navigation;

use Stringable;

interface NavigationInterface
{
    /**
     * The name of the Navigation
     */
    public function getTitle(): Stringable|string|null;

    /**
     * @return LinkInterface[]
     */
    public function getLinks(): array;

    public function addLink(LinkInterface $link): NavigationInterface;

    public function removeLink(LinkInterface $link): NavigationInterface;
}
