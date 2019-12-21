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
 * Ordering parameters as part of InfiniteScroll request.
 *
 * @property string $column Column to which ordering should be applied.
 * @property string $dir    Ordering direction for this column.
 */
class Order extends ValueObject implements \JsonSerializable
{
    public const ASC = 'asc';

    public const DESC = 'desc';

    protected $column;

    protected $dir;

    /**
     * Initializing constructor.
     *
     * @param string $column
     * @param string $dir
     */
    public function __construct(string $column, string $dir)
    {
        $this->column = $column;
        $this->dir = $dir;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'column' => $this->column,
            'dir' => $this->dir,
        ];
    }
}
