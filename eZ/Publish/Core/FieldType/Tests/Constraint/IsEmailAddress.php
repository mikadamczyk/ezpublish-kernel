<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace eZ\Publish\Core\FieldType\Tests\Constraint;

use eZ\Publish\Core\FieldType\EmailAddress\Value as EmailAddress;
use eZ\Publish\Core\FieldType\Validator;
use PHPUnit\Framework\Constraint\Constraint;
use function is_string;


class IsEmailAddress extends Constraint
{
    /** @var \eZ\Publish\Core\FieldType\Validator */
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function matches($email): bool
    {
        if (!is_string($email)) {
            return false;
        }

        return $this->validator->validate(new EmailAddress($email)) && $this->validator->getMessage() === [];
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return 'is a valid email address';
    }
}