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

namespace Pimcore\Targeting\Condition;

use Pimcore\Targeting\Model\VisitorInfo;

class Url extends AbstractVariableCondition implements ConditionInterface
{
    private ?string $pattern = null;

    /**
     * @param null|string $pattern
     */
    public function __construct(string $pattern = null)
    {
        $this->pattern = $pattern;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromConfig(array $config): static
    {
        return new static($config['url'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function canMatch(): bool
    {
        return !empty($this->pattern);
    }

    /**
     * {@inheritdoc}
     */
    public function match(VisitorInfo $visitorInfo): bool
    {
        $request = $visitorInfo->getRequest();

        $uri = $request->getUri();
        $result = preg_match($this->pattern, $uri);

        if ($result) {
            $this->setMatchedVariable('uri', $uri);

            return true;
        }

        return false;
    }
}
