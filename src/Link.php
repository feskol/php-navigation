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

use Feskol\Navigation\Contracts\HierarchicalLinkInterface;
use Feskol\Navigation\Contracts\HyperLinkInterface;
use Feskol\Navigation\Contracts\LinkInterface;

/**
 * Represents a navigation link with hierarchical structure and active status.
 */
class Link extends AbstractHyperLink implements LinkInterface, HierarchicalLinkInterface, HyperLinkInterface
{
    private \Stringable|string|null $title = null;

    private bool $isActive = false;

    private ?LinkInterface $parent = null;

    private array $children = [];

    private int $activeChildrenCount = 0;

    /**
     * @inheritDoc
     */
    public function getTitle(): \Stringable|string|null
    {
        return $this->title;
    }

    /**
     * Sets the title of the link.
     *
     * @param \Stringable|string|null $title
     * @return $this
     */
    public function setTitle(\Stringable|string|null $title): static
    {
        $this->title = $title;
        return $this;
    }


    /**
     * @inheritDoc
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * Sets the active status of the link.
     *
     * If the active status changes, it updates the parent's active status recursively.
     *
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive(bool $isActive): static
    {
        // If active-status changed
        if ($this->isActive !== $isActive) {

            // set active-status
            $this->isActive = $isActive;

            // handle recursive active-status update
            if ($this->hasParent()) {
                if ($isActive) {
                    $this->parent->recursiveAddActiveStatus();
                } else {
                    $this->parent->recursiveRemoveActiveStatus();
                }
            }
        }

        return $this;
    }

    /**
     * Recursively adds the active status to the parent link.
     *
     * Increments the active children count and updates the parent's status if necessary.
     *
     * @return void
     */
    private function recursiveAddActiveStatus(): void
    {
        // increment activeChildrenCount
        if ($this->hasChildren()) {
            $this->activeChildrenCount++;
        }

        // only update parents recursive, if active-status was false
        if (!$this->isActive) {
            $this->isActive = true;

            if ($this->hasParent()) {
                $this->parent->recursiveAddActiveStatus();
            }
        }
    }

    /**
     * Recursively removes the active status from the parent link.
     *
     * Decrements the active children count and updates the parent's status if necessary.
     *
     * @return void
     */
    private function recursiveRemoveActiveStatus(): void
    {
        if ($this->hasChildren()) {
            // decrement activeChildrenCount
            $this->activeChildrenCount--;

            // If no active children left, set the current link as inactive
            if ($this->activeChildrenCount === 0) {
                $this->isActive = false;

                // Recursively remove active-status from the parent
                if ($this->hasParent()) {
                    $this->parent->recursiveRemoveActiveStatus();
                }
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getParent(): ?static
    {
        return $this->parent;
    }

    /**
     * @inheritDoc
     */
    public function hasParent(): bool
    {
        return $this->parent !== null;
    }

    /**
     * @inheritDoc
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @inheritDoc
     */
    public function hasChildren(): bool
    {
        return !empty($this->children);
    }

    /**
     * Sets the children of the link.
     *
     * @param static[] $children An array of child links to set.
     * @return $this
     */
    public function setChildren(array $children): static
    {
        // Removes the current children and updates the active status of parents accordingly.
        foreach ($this->children as $child) {
            $this->removeChild($child);
        }

        // add the new children
        foreach ($children as $child) {
            $this->addChild($child);
        }

        return $this;
    }

    /**
     * Adds a child link to the current link.
     *
     * @param LinkInterface $child The child link to add.
     * @return $this
     */
    public function addChild(LinkInterface $child): static
    {
        // set the child parent
        $child->parent = $this;

        // add the link
        $this->children[] = $child;

        // If the child is active, it updates the parent's active status.
        if ($child->isActive()) {
            $this->recursiveAddActiveStatus();
        }

        return $this;
    }

    /**
     * Removes a child link from the current link.
     *
     * @param LinkInterface $child The child link to remove.
     * @return $this
     */
    public function removeChild(LinkInterface $child): static
    {
        $key = array_search($child, $this->children, true);

        if ($key !== false) {

            // unset child parent
            $child->parent = null;

            // If the child was active, it updates the parent's active status accordingly.
            if ($child->isActive()) {
                $this->recursiveRemoveActiveStatus();
            }

            // remove the link
            unset($this->children[$key]);
        }

        return $this;
    }

    /**
     * Returns the number of active children (only direct children).
     *
     * @return int
     */
    public function getActiveChildrenCount(): int
    {
        return $this->activeChildrenCount;
    }
}
