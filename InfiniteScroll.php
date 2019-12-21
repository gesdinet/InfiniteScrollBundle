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

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * InfiniteScroll lookup service.
 */
class InfiniteScroll implements InfiniteScrollInterface
{
    protected $logger;

    protected $validator;

    /** @var InfiniteScrollHandlerInterface[] List of registered DataTable services. */
    protected $services = [];

    /**
     * Dependency Injection constructor.
     *
     * @param LoggerInterface    $logger
     * @param ValidatorInterface $validator
     */
    public function __construct(LoggerInterface $logger, ValidatorInterface $validator)
    {
        $this->logger = $logger;
        $this->validator = $validator;
    }

    /**
     * Registers specified InfiniteScroll handler.
     *
     * @param InfiniteScrollHandlerInterface $service service of the InfiniteScroll handler
     * @param string                         $id      infinitescroll ID
     */
    public function addService(InfiniteScrollHandlerInterface $service, string $id = null)
    {
        $service_id = $id ?? $service::ID;

        if (null !== $service_id) {
            $this->services[$service_id] = $service;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, string $id): InfiniteScrollResults
    {
        $this->logger->debug('Handle InfiniteScroll request', [$id]);

        // Retrieve sent parameters.
        $params = new Parameters();

        $keyParams = [
            'pagination',
            'query',
            'sort',
        ];

        $pagination = $request->get('pagination');

        $start = ($pagination['page'] - 1) * $pagination['perpage'];
        $params->start = ($start > 0 && (!isset($pagination['total']) || $start < $pagination['total'])) ? $start : 0;
        $params->length = $pagination['perpage'];
        $params->search = $request->get('query')['generalSearch'] ?? '';
        $params->order = [$request->get('sort')];

        $allParams = $request->isMethod(Request::METHOD_POST)
            ? $request->request->all()
            : $request->query->all();

        $params->customData = array_diff_key($allParams, array_flip($keyParams));

        // Validate sent parameters.
        $violations = $this->validator->validate($params);

        if (count($violations)) {
            $message = $violations->get(0)->getMessage();
            $this->logger->error($message, ['request']);

            throw new InfiniteScrollException($message);
        }

        // Check for valid handler is registered.
        if (!array_key_exists($id, $this->services)) {
            $message = 'Unknown InfiniteScroll ID.';
            $this->logger->error($message, [$id]);

            throw new InfiniteScrollException($message);
        }

        // Convert sent parameters into data model.
        $query = new InfiniteScrollQuery($params);

        // Pass the data model to the handler.
        $result = null;

        $timer_started = microtime(true);

        try {
            $result = $this->services[$id]->handle($query);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), [$this->services[$id]]);

            throw new InfiniteScrollException($e->getMessage());
        } finally {
            $timer_stopped = microtime(true);
            $this->logger->debug('InfiniteScroll processing time', [$timer_stopped - $timer_started, $this->services[$id]]);
        }
        // Validate results returned from handler.
        $violations = $this->validator->validate($result);

        if (count($violations)) {
            $message = $violations->get(0)->getMessage();
            $this->logger->error($message, ['response']);

            throw new InfiniteScrollException($message);
        }

        return $result;
    }
}
