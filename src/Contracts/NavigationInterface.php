<?php
/**
 * This file is part of the php-navigation project.
 *
 * (c) Festim Kolgeci <festim.kolgei@pm.me>
 *
 * For complete copyright and license details, please refer
 * to the LICENSE file distributed with this source code.
 */

namespace Feskol\Navigation\Contracts;

use Stringable;

/**
 * Represents a navigation structure that contains a collection of links.
 */
interface NavigationInterface
{
    /**
     * Gets the title of the navigation.
     *
     * @return Stringable|string|null
     */
    public function getTitle(): Stringable|string|null;

    /**
     * Gets the list of links in the navigation.
     *
     * @return LinkInterface[]
     */
    public function getLinks(): array;
}
