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


/**
 * Represents a navigation link
 */
interface LinkInterface extends HierarchicalLinkInterface, HyperLinkInterface
{
    /**
     * Retrieves the title of the link.
     *
     * @return \Stringable|string|null
     */
    public function getTitle(): \Stringable|string|null;

    /**
     * Sets the title
     */
    public function setTitle(\Stringable|string|null $title): static;

    /**
     * Checks if the link is active.
     *
     * @return bool True if the link is active, false otherwise.
     */
    public function isActive(): bool;

    /**
     * Sets the active status of the link.
     */
    public function setIsActive(bool $isActive): static;

    /**
     * Checks if the link has children with active status 'true'.
     *
     * @return bool
     */
    public function hasActiveChildren(): bool;
}
