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
 * Represents and hierarchical structure of links
 */
interface HierarchicalLinkInterface
{
    /**
     * Retrieves the parent link of the current link.
     *
     * @return static|null
     */
    public function getParent(): ?LinkInterface;

    /**
     * Checks if the link has a parent.
     *
     * Typically, top-level links (i.e., the first links in a hierarchical navigation structure)
     * do not have a parent.
     *
     * @return bool
     */
    public function hasParent(): bool;

    /**
     * Retrieves the children of the link.
     *
     * @return LinkInterface[]
     */
    public function getChildren(): array;

    /**
     * Checks if the link has children.
     *
     * @return bool
     */
    public function hasChildren(): bool;

    /**
     * Sets the children of the link.
     *
     * @param LinkInterface[] $children
     * @return $this
     */
    public function setChildren(array $children): static;

    /**
     * Adds a child link to the current link.
     *
     * @param LinkInterface $child
     * @return $this
     */
    public function addChild(LinkInterface $child): static;

    /**
     * Removes a child link from the current link.
     *
     * @param LinkInterface $child
     * @return $this
     */
    public function removeChild(LinkInterface $child): static;
}
