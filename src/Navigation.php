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

class Navigation implements NavigationInterface
{
    private Stringable|string|null $title = null;

    private array $links = [];

    public function getTitle(): Stringable|string|null
    {
        return $this->title;
    }

    public function setTitle(Stringable|string|null $title): static
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return LinkInterface[]
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @param LinkInterface[] $links
     * @return $this
     */
    public function setLinks(array $links): static
    {
        $this->links = $links;
        return $this;
    }

    public function addLink(LinkInterface $link): static
    {
        $this->links[] = $link;

        return $this;
    }

    public function removeLink(LinkInterface $link): static
    {
        $key = array_search($link, $this->links, true);

        if ($key !== false) {
            unset($this->links[$key]);
        }

        return $this;
    }
}
