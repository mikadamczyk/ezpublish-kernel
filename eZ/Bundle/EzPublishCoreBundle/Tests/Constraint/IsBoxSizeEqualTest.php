<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace eZ\Bundle\EzPublishCoreBundle\Tests\Constraint;

use PHPUnit\Framework\TestCase;
use Imagine\Image\Box;

class IsBoxSizeEqualTest extends TestCase
{
    private $constraint;

    public function setUp(): void
    {
        $this->constraint = new IsBoxSizeEqual([100, 200]);
    }

    public function testMatches()
    {
        $this->assertTrue($this->constraint->matches(new Box(100, 200)));
    }

    public function testNotMatchesForUsupportedClass()
    {
        $this->assertFalse($this->constraint->matches(new \stdClass()));
    }

    public function testNotMatchesForWrongSize()
    {
        $this->assertFalse($this->constraint->matches(new Box(500, 500)));
    }
}