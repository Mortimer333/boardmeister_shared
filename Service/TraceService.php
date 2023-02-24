<?php

declare(strict_types=1);

namespace Shared\Service;

use Shared\Service\Util\BinUtilService;
use Symfony\Component\HttpFoundation\Response;
use Shared\Entity\Trace;
use Symfony\Component\HttpFoundation\Request;

class TraceService
{
    public function create(\Throwable $e, ?Request $request = null, ?Response $response = null): void
    {
        if (!$response) {
            $response = $this->httpUtilService->getProperResponseFromException($e);
        }

        $trace = (new Trace())
            ->setIp($this->binUtilService->getCurrentIp())
            ->setCode($e->getCode())
            ->setResponse(
                json_decode($response->getContent(), true) ?? ['failure' => $response->getContent()]
            )
        ;

        if ($request) {
            $method = $request->getMethod();
            $trace->setEndpoint($request->getMethod() . ' ' . $request->getPathInfo());
            if ($method !== 'GET' && $method !== 'HEAD') {
                $trace->setPayload(json_decode($request->getContent(), true) ?? ['failure' => $request->getContent()]);
            }
        }

        $user = $this->security->getUser();
        if ($user) {
            $trace->setUser($user);
        }

        if (!$this->em->isOpen()) {
            $this->managerRegistry->resetManager(); // Have to reset entity on exception
        }

        $this->em->persist($trace);
        $this->em->flush();
    }
}
