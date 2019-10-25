<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace eZ\Publish\Core\MVC\Symfony\SiteAccess\Tests;

use eZ\Publish\Core\MVC\Symfony\SiteAccess\Matcher;
use eZ\Publish\Core\MVC\Symfony\SiteAccess\Router;

/**
 * This class represents settings which will be used to construct SiteAccessProvider mock.
 */
final class SiteAccessSetting
{
    public $name;

    public $isDefined;

    public $matchingType;

    /** @var string[] */
    public $groups;

    /** @var \eZ\Publish\Core\MVC\Symfony\SiteAccess\Matcher|null */
    public $matcher;

    public function __construct(
        string $name,
        bool $isDefined,
        string $matchingType = Router::DEFAULT_SA_MATCHING_TYPE,
        ?Matcher $matcher = null,
        array $groups = []
    ) {
        $this->name = $name;
        $this->isDefined = $isDefined;
        $this->matchingType = $matchingType;
        $this->matcher = $matcher;
        $this->groups = $groups;
    }
}
