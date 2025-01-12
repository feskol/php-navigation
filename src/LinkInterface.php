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


/**
 * Represents a navigation link
 */
interface LinkInterface extends HyperLinkInterface
{
    /**
     * The title of the link
     */
    public function getTitle(): \Stringable|string|null;

    public function isActive(): bool;

    public function getParent(): LinkInterface;

    /**
     * @return LinkInterface[]
     */
    public function getChildren(): array;
}
