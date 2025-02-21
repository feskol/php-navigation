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

use Feskol\Navigation\Contracts\LinkInterface;
use Feskol\Navigation\Contracts\NavigationInterface;

/**
 * Represents a navigation structure that contains a collection of links.
 */
class Navigation implements NavigationInterface
{
    /**
     * @var \Stringable|string|null The title of the navigation.
     */
    private \Stringable|string|null $title = null;

    /**
     * @var LinkInterface[] List of navigation links.
     */
    private array $links = [];

    /**
     * @inheritDoc
     */
    public function getTitle(): \Stringable|string|null
    {
        return $this->title;
    }

    /**
     * @inheritDoc
     */
    public function setTitle(\Stringable|string|null $title): static
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @inheritDoc
     */
    public function setLinks(array $links): static
    {
        $this->links = $links;
        return $this;
    }

    /**
     * Adds a new link to the navigation.
     *
     * @param LinkInterface $link
     * @return $this
     */
    public function addLink(LinkInterface $link): static
    {
        $this->links[] = $link;

        return $this;
    }

    /**
     * Removes a link from the navigation.
     *
     * @param LinkInterface $link
     * @return $this
     */
    public function removeLink(LinkInterface $link): static
    {
        $key = array_search($link, $this->links, true);

        if ($key !== false) {
            unset($this->links[$key]);
        }

        return $this;
    }
}
