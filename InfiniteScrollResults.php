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

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class InfiniteScrollResults.
 */
class InfiniteScrollResults implements \JsonSerializable
{
    /**
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(value="0")
     */
    public $page = 0;

    /**
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(value="0")
     */
    public $pages = 0;

    /**
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(value="0")
     */
    public $perpage = 0;

    /**
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(value="0")
     */
    public $total = 0;

    /**
     * @Assert\NotNull
     * @Assert\Choice(choices={"asc", "desc"}, strict=true)
     */
    public $sort = 'asc';

    /**
     * @Assert\NotNull
     */
    public $field = '';

    /**
     * @Assert\NotNull
     * @Assert\Type(type="array")
     */
    public $data = [];

    /**
     * Convert results into array as expected by InfiniteScroll plugin.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'meta' => [
                'page' => $this->page,
                'pages' => $this->pages,
                'perpage' => $this->perpage,
                'total' => $this->total,
                'sort' => $this->sort,
                'field' => $this->field,
            ],
            'data' => $this->data,
        ];
    }
}
