<?php
/**
 * This file is part of the php-navigation project.
 *
 * (c) Festim Kolgeci <festim.kolgei@pm.me>
 *
 * For complete copyright and license details, please refer
 * to the LICENSE file distributed with this source code.
 */

namespace Feskol\Tests\fixtures;

class TranslatableMessage
{
    public function __construct(private string $message)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function __toString(): string
    {
        return $this->message;
    }
}
