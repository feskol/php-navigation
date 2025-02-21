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

use Feskol\Navigation\Contracts\HyperLinkInterface;

/**
 * Abstract class providing an implementation for the <a>-tag
 *
 * @see https://www.w3schools.com/tags/tag_a.asp
 */
abstract class AbstractHyperLink implements HyperLinkInterface
{
    private ?string $href = null;
    private ?string $hreflang = null;
    private ?string $target = null;
    private ?string $rel = null;
    private ?string $type = null;
    private ?string $referrerPolicy = null;
    private ?string $media = null;

    /** @var array<string>|null */
    private ?array $ping = null;
    private bool $isDownload = false;

    /**
     * @inheritDoc
     */
    public function getHref(): ?string
    {
        return $this->href;
    }

    public function setHref(?string $href): static
    {
        $this->href = $href;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHreflang(): ?string
    {
        return $this->hreflang;
    }

    public function setHreflang(?string $hreflang): static
    {
        $this->hreflang = $hreflang;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(?string $target): static
    {
        $this->target = $target;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRel(): ?string
    {
        return $this->rel;
    }

    public function setRel(?string $rel): static
    {
        $this->rel = $rel;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getReferrerPolicy(): ?string
    {
        return $this->referrerPolicy;
    }

    public function setReferrerPolicy(?string $referrerPolicy): static
    {
        $this->referrerPolicy = $referrerPolicy;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(?string $media): static
    {
        $this->media = $media;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPing(): ?string
    {
        return $this->ping ? join(' ', $this->ping) : null;
    }

    /**
     * @param array<string>|null $ping
     * @return $this
     */
    public function setPing(?array $ping): static
    {
        $this->ping = $ping;
        return $this;
    }

    public function addPing(string $url): static
    {
        $this->ping[] = $url;
        return $this;
    }

    public function removePing(string $url): static
    {
        $this->ping = array_diff($this->ping, [$url]);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isDownload(): bool
    {
        return $this->isDownload;
    }

    public function setIsDownload(bool $isDownload): static
    {
        $this->isDownload = $isDownload;
        return $this;
    }
}
