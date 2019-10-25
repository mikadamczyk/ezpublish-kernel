<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\Core\MVC\Symfony\SiteAccess\Provider;

use eZ\Publish\Core\MVC\Symfony\SiteAccess;
use eZ\Publish\Core\MVC\Symfony\SiteAccess\SiteAccessProviderInterface;
use eZ\Publish\Core\MVC\Symfony\SiteAccessGroup;
use Traversable;

final class StaticSiteAccessProvider implements SiteAccessProviderInterface
{
    /** @var string[] */
    private $siteAccessList;

    /** @var string[] */
    private $groupsBySiteAccess;

    /**
     * @param string[] $siteAccessList
     * @param array $groupsBySiteAccess
     */
    public function __construct(
        array $siteAccessList,
        array $groupsBySiteAccess
    ) {
        $this->siteAccessList = $siteAccessList;
        $this->groupsBySiteAccess = $groupsBySiteAccess;
    }

    public function getSiteAccesses(): Traversable
    {
        foreach ($this->siteAccessList as $name) {
            yield new SiteAccess($name, null, null, self::class);
        }

        yield from [];
    }

    public function isDefined(string $name): bool
    {
        return \in_array($name, $this->siteAccessList, true);
    }

    public function getSiteAccess(string $name): SiteAccess
    {
        $siteAccess = new SiteAccess($name, null, null, self::class);
        if (isset($this->groupsBySiteAccess[$name])) {
            $siteAccess->groups = array_map(function($group) {
                return new SiteAccessGroup($group);
            }, $this->groupsBySiteAccess[$name]);
        }

        return $siteAccess;
    }
}
