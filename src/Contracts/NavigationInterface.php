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
 * Represents a navigation structure that contains a collection of links.
 */
interface NavigationInterface
{
    /**
     * Gets the title of the navigation.
     */
    public function getTitle(): \Stringable|string|null;

    /**
     * Sets the title of the navigation.
     */
    public function setTitle(\Stringable|string|null $title): static;

    /**
     * Gets the list of links in the navigation.
     *
     * @return LinkInterface[]
     */
    public function getLinks(): array;

    /**
     * Sets the list of links in the navigation.
     *
     * @param LinkInterface[] $links
     */
    public function setLinks(array $links): static;

    /**
     * Adds a new link to the navigation.
     *
     * @param LinkInterface $link
     * @return $this
     */
    public function addLink(LinkInterface $link): static;

    /**
     * Removes a link from the navigation.
     *
     * @param LinkInterface $link
     * @return $this
     */
    public function removeLink(LinkInterface $link): static;
}
