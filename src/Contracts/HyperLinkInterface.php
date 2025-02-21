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
 * Representing the <a> tag {@see https://www.w3schools.com/tags/tag_a.asp}
 */
interface HyperLinkInterface
{
    public const TARGET_BLANK = '_blank';
    public const TARGET_SELF = '_self';
    public const TARGET_PARENT = '_parent';
    public const TARGET_TOP = '_top';

    /**
     * @see https://www.w3schools.com/tags/att_a_href.asp
     */
    public function getHref(): ?string;

    /**
     * Setter for href
     *
     * @param string|null $href
     * @return $this
     */
    public function setHref(?string $href): static;

    /**
     * @see https://www.w3schools.com/tags/att_a_hreflang.asp
     */
    public function getHreflang(): ?string;


    /**
     * Setter for hreflang
     *
     * @param string|null $hreflang
     * @return $this
     */
    public function setHreflang(?string $hreflang): static;

    /**
     * @see https://www.w3schools.com/tags/att_a_target.asp
     */
    public function getTarget(): ?string;

    /**
     * Setter for target
     *
     * @param string|null $target
     * @return $this
     *
     * @see HyperLinkInterface::TARGET_BLANK: You can use the constants of HyperLinkInterface
     */
    public function setTarget(?string $target): static;

    /**
     * @see https://www.w3schools.com/tags/att_a_rel.asp
     */
    public function getRel(): ?string;

    /**
     * Setter for rel
     *
     * @param string|null $rel
     * @return $this
     */
    public function setRel(?string $rel): static;

    /**
     * @see https://www.w3schools.com/tags/att_a_type.asp
     */
    public function getType(): ?string;

    /**
     * Setter for type
     *
     * @param string|null $type
     * @return $this
     */
    public function setType(?string $type): static;

    /**
     * @see https://www.w3schools.com/tags/att_a_referrepolicy.asp
     */
    public function getReferrerPolicy(): ?string;

    /**
     * Setter for referrerpolicy
     *
     * @param string|null $referrerPolicy
     * @return $this
     */
    public function setReferrerPolicy(?string $referrerPolicy): static;

    /**
     * @see https://www.w3schools.com/tags/att_a_media.asp
     */
    public function getMedia(): ?string;

    /**
     * Setter for media
     *
     * @param string|null $media
     * @return $this
     */
    public function setMedia(?string $media): static;

    /**
     * @see https://www.w3schools.com/tags/att_a_ping.asp
     */
    public function getPing(): ?string;

    /**
     * Setter for ping
     *
     * @param string|null $ping space-separated list of URLs
     * @return $this
     */
    public function setPing(?string $ping): static;

    /**
     * Adds an url to ping
     *
     * @param string $url One url to add from the ping array
     * @return $this
     */
    public function addPing(string $url): static;

    /**
     * Removes an url from ping
     *
     * @param string $url One url to remove from the ping array
     * @return $this
     */
    public function removePing(string $url): static;

    /**
     * @see https://www.w3schools.com/tags/att_a_download.asp
     */
    public function isDownload(): bool;

    /**
     * Setter for isDownload
     *
     * @param bool $isDownload Determines if the "download" attribute should be added or not
     * @return $this
     */
    public function setIsDownload(bool $isDownload): static;
}
