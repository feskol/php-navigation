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
    /**
     * @see https://www.w3schools.com/tags/att_a_href.asp
     */
    public function getHref(): ?string;

    /**
     * @see https://www.w3schools.com/tags/att_a_hreflang.asp
     */
    public function getHreflang(): ?string;

    /**
     * @see https://www.w3schools.com/tags/att_a_target.asp
     */
    public function getTarget(): ?string;

    /**
     * @see https://www.w3schools.com/tags/att_a_rel.asp
     */
    public function getRel(): ?string;

    /**
     * @see https://www.w3schools.com/tags/att_a_type.asp
     */
    public function getType(): ?string;

    /**
     * @see https://www.w3schools.com/tags/att_a_referrepolicy.asp
     */
    public function getReferrerPolicy(): ?string;

    /**
     * @see https://www.w3schools.com/tags/att_a_media.asp
     */
    public function getMedia(): ?string;

    /**
     * @see https://www.w3schools.com/tags/att_a_ping.asp
     */
    public function getPing(): ?string;

    /**
     * @see https://www.w3schools.com/tags/att_a_download.asp
     */
    public function isDownload(): bool;
}
