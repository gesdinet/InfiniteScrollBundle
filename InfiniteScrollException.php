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

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Exception in last InfiniteScroll request handling.
 * Contains HTTP status code and can be used in HTTP Response object.
 */
class InfiniteScrollException extends BadRequestHttpException
{
    /**
     * {@inheritdoc}
     */
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $previous, $code);
    }
}
