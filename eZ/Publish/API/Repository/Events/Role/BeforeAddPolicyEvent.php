<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\API\Repository\Events\Role;

use eZ\Publish\API\Repository\Values\User\PolicyCreateStruct;
use eZ\Publish\API\Repository\Values\User\Role;
use eZ\Publish\SPI\Repository\Event\BeforeEvent;
use UnexpectedValueException;

final class BeforeAddPolicyEvent extends BeforeEvent
{
    /** @var \eZ\Publish\API\Repository\Values\User\Role */
    private $role;

    /** @var \eZ\Publish\API\Repository\Values\User\PolicyCreateStruct */
    private $policyCreateStruct;

    /** @var \eZ\Publish\API\Repository\Values\User\Role|null */
    private $updatedRole;

    public function __construct(Role $role, PolicyCreateStruct $policyCreateStruct)
    {
        $this->role = $role;
        $this->policyCreateStruct = $policyCreateStruct;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getPolicyCreateStruct(): PolicyCreateStruct
    {
        return $this->policyCreateStruct;
    }

    public function getUpdatedRole(): Role
    {
        if (!$this->hasUpdatedRole()) {
            throw new UnexpectedValueException(sprintf('Return value is not set or not a type of %s. Check hasUpdatedRole() or set it by setUpdatedRole() before you call getter.', Role::class));
        }

        return $this->updatedRole;
    }

    public function setUpdatedRole(?Role $updatedRole): void
    {
        $this->updatedRole = $updatedRole;
    }

    public function hasUpdatedRole(): bool
    {
        return $this->updatedRole instanceof Role;
    }
}
