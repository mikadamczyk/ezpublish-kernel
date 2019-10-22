<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\Core\MVC\Symfony\SiteAccess\Provider;

use eZ\Publish\Core\MVC\Symfony\SiteAccess;
use eZ\Publish\Core\MVC\Symfony\SiteAccess\SiteAccessProviderInterface;
use Traversable;

final class StaticSiteAccessProvider implements SiteAccessProviderInterface
{
    /** @var string[] */
    private $siteAccessList;

    /**
     * @param string[] $siteAccessList
     */
    public function __construct(
        array $siteAccessList
    ) {
        $this->siteAccessList = $siteAccessList;
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
        return new SiteAccess($name, null, null, self::class);
    }
}
