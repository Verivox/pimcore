<?php

declare(strict_types=1);

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

namespace Pimcore\Analytics\SiteId;

use Pimcore\Model\Site;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Represents an analytics site config key which is either just "default" without
 * an associated site or a combination of a site with its config key "site_<siteId>".
 */
class SiteId
{
    const CONFIG_KEY_MAIN_DOMAIN = '0';

    private string $configKey;

    private ?Site $site = null;

    private function __construct(string $configKey, Site $site = null)
    {
        $this->configKey = $configKey;
        $this->site = $site;
    }

    public static function forMainDomain(): self
    {
        return new self(self::CONFIG_KEY_MAIN_DOMAIN);
    }

    public static function forSite(Site $site): self
    {
        $configKey = sprintf('site_%s', $site->getId());

        return new self($configKey, $site);
    }

    public function getConfigKey(): string
    {
        return $this->configKey;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function getTitle(TranslatorInterface $translator): string
    {
        $site = $this->site;

        $name = null;

        if (null === $site) {
            if (!empty($mainDomain = \Pimcore\Config::getSystemConfiguration('general')['domain'])) {
                return $mainDomain;
            }

            if ($currentDomain = \Pimcore\Tool::getHostname()) {
                return $currentDomain;
            }

            return $translator->trans('main_site', [], 'admin');
        }

        if ($site->getMainDomain()) {
            $name = $site->getMainDomain();
        } elseif ($site->getRootDocument()) {
            $name = $site->getRootDocument()->getKey();
        }

        $siteSuffix = sprintf(
            '%s: %d',
            $translator->trans('site', [], 'admin'),
            $site->getId()
        );

        if (empty($name)) {
            $name = $siteSuffix;
        } else {
            $name = sprintf('%s (%s)', $name, $siteSuffix);
        }

        return $name;
    }
}
