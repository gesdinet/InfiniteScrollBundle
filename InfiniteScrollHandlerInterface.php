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
 * InfiniteScroll handler.
 */
interface InfiniteScrollHandlerInterface
{
    public const ID = null;

    /**
     * Handles specified InfiniteScroll request.
     *
     * @param InfiniteScrollQuery $request
     *
     * @return InfiniteScrollResults
     */
    public function handle(InfiniteScrollQuery $request): InfiniteScrollResults;
}
