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

use Symfony\Component\HttpFoundation\Request;

/**
 * InfiniteScroll lookup service.
 */
interface InfiniteScrollInterface
{
    /**
     * Handles specified InfiniteScroll request.
     *
     * @param Request $request original request
     * @param string  $id      infiniteScroll ID
     *
     * @return InfiniteScrollResults object with data to return in JSON response
     */
    public function handle(Request $request, string $id): InfiniteScrollResults;
}
