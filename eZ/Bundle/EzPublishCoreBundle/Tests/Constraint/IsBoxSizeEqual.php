<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace eZ\Bundle\EzPublishCoreBundle\Tests\Constraint;

use Imagine\Image\BoxInterface;
use PHPUnit\Framework\Constraint\Constraint;

class IsBoxSizeEqual extends Constraint
{
    /** @var int */
    private $expectedWidth;

    /** @var int  */
    private $expectedHeight;

    public function __construct(array $expected)
    {
        $this->expectedWidth = (int)$expected[0];
        $this->expectedHeight = (int)$expected[1];
    }

    public function matches($actual): bool
    {
        if (!$actual instanceof BoxInterface) {
            return false;
        }

        return $this->expectedWidth === $actual->getWidth() && $this->expectedHeight ===$actual->getHeight();
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return sprintf("has the same size as \n\t'width' => %d \n\t'height' => %d", $this->expectedWidth, $this->expectedHeight);
    }
}