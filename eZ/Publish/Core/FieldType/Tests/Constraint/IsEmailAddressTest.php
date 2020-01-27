<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace eZ\Publish\Core\FieldType\Tests\Constraint;

use eZ\Publish\Core\FieldType\Validator\EmailAddressValidator;
use PHPUnit\Framework\TestCase;


class IsEmailAddressTest extends TestCase
{
    private $constraint;

    public function setUp(): void
    {
        $validator = new EmailAddressValidator();
        $validator->Extent = 'regex';
        $this->constraint = new IsEmailAddress($validator);
    }

    public function testMatches(): void
    {
        $this->assertTrue($this->constraint->matches('john.doe@example.com'));
    }

    public function testNotMatchesForUsupportedClass(): void
    {
        $this->assertFalse($this->constraint->matches(123));
    }

    public function testNotMatchesForWrongSize(): void
    {
        $this->assertFalse($this->constraint->matches('.john.doe@example.com'));
    }
}