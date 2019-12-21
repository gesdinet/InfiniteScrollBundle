<?php

/*
 * This file is part of the Gesdinet vbApp package.
 *
 * (c) Gesdinet <contact@Gesdinet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gesdinet\InfiniteScrollBundle;

/**
 * Search parameters as part of InfiniteScroll request.
 *
 * @see https://keenthemes.com/metronic/documentation.html#sec14
 *
 * @property string $value Search value.
 * @property bool   $regex Whether the search value should be treated as a regular expression for advanced searching.
 */
class Search extends ValueObject implements \JsonSerializable
{
    protected $value;

    /**
     * Initializing constructor.
     *
     * @param string $value
     */
    public function __construct(string $value = null)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'value' => $this->value,
        ];
    }
}
