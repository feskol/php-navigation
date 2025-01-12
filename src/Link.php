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
 *
 * <a> tag attributes {@see https://www.w3schools.com/tags/tag_a.asp}
 */
class Link implements LinkInterface
{
    /**
     * The title of the Link
     */
    private \Stringable|string|null $title = null;

    private ?string $href = null;
    private ?string $hreflang = null;
    private ?string $target = null;
    private ?string $rel = null;
    private ?string $type = null;
    private ?string $referrerPolicy = null;
    private ?string $media = null;
    private ?string $ping = null;
    private bool $isDownload = false;

    /**
     * If the link is currently active
     */
    private bool $isActive = false;

    private ?LinkInterface $parent = null;

    private array $children = [];

    private int $activeChildrenCount = 0;

    public function getTitle(): \Stringable|string|null
    {
        return $this->title;
    }

    public function setTitle(\Stringable|string|null $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getHref(): ?string
    {
        return $this->href;
    }

    public function setHref(?string $href): static
    {
        $this->href = $href;
        return $this;
    }

    public function getHreflang(): ?string
    {
        return $this->hreflang;
    }

    public function setHreflang(?string $hreflang): static
    {
        $this->hreflang = $hreflang;
        return $this;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(?string $target): static
    {
        $this->target = $target;
        return $this;
    }

    public function getRel(): ?string
    {
        return $this->rel;
    }

    public function setRel(?string $rel): static
    {
        $this->rel = $rel;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getReferrerPolicy(): ?string
    {
        return $this->referrerPolicy;
    }

    public function setReferrerPolicy(?string $referrerPolicy): static
    {
        $this->referrerPolicy = $referrerPolicy;
        return $this;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(?string $media): static
    {
        $this->media = $media;
        return $this;
    }

    public function getPing(): ?string
    {
        return $this->ping;
    }

    public function setPing(?string $ping): static
    {
        $this->ping = $ping;
        return $this;
    }

    public function isDownload(): bool
    {
        return $this->isDownload;
    }

    public function setIsDownload(bool $isDownload): static
    {
        $this->isDownload = $isDownload;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

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
     * Recursive: add link's parents active-status
     */
    private function recursiveAddActiveStatus(): void
    {
        // add +1 activeChildrenCount
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
     * Recursive: remove link's parents active-status
     */
    private function recursiveRemoveActiveStatus(): void
    {
        if ($this->hasChildren()) {
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

    public function getParent(): static
    {
        return $this->parent;
    }

    public function hasParent(): bool
    {
        return $this->parent !== null;
    }

    public function setParent(Link $parent): static
    {
        $this->parent = $parent;
        return $this;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function hasChildren(): bool
    {
        return !empty($this->children);
    }

    /**
     * @param static[] $children
     */
    public function setChildren(array $children): static
    {
        $this->children = [];
        $this->activeChildrenCount = 0;

        foreach ($children as $child) {
            $this->addChild($child);
        }

        return $this;
    }

    public function addChild(LinkInterface $child): static
    {
        $child->setParent($this);

        $this->children[] = $child;

        // If the child is active, we increment the active children count
        if ($child->isActive()) {
            $this->activeChildrenCount++;

            // If the current link is not active, make it active and propagate the status to parent
            if (!$this->isActive) {
                $this->isActive = true;

                // Update the parent's active-status recursively
                if ($this->hasParent()) {
                    $this->parent->recursiveAddActiveStatus();
                }
            }
        }

        return $this;
    }

    public function removeChild(LinkInterface $child): static
    {
        $key = array_search($child, $this->children, true);

        if ($key !== false) {

            // If the child was active, we decrement the active children count
            if ($child->isActive()) {
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

            // remove the link
            unset($this->children[$key]);
        }

        return $this;
    }

    public function getActiveChildrenCount(): int
    {
        return $this->activeChildrenCount;
    }
}
