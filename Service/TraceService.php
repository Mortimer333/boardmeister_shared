<?php

declare(strict_types=1);

namespace Shared\Service;

use Shared\Entity\Trace;
use Shared\Entity\User;
use Shared\Service\Util\BinUtilService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TraceService
{
    public function create(\Throwable $e, ?Request $request = null, ?Response $response = null): Trace
    {
        if (!$response) {
            $response = $this->httpUtilService->getProperResponseFromException($e);
        }

        $status = $this->httpUtilService->getStatusCode($e);
        $trace = (new Trace())
            ->setIp($this->binUtilService->getCurrentIp())
            ->setCode($status)
            ->setResponse(
                json_decode($response->getContent(), true) ?? ['failure' => $response->getContent()]
            )
            ->setTrace($e->getTrace())
        ;

        if ($request) {
            $method = $request->getMethod();
            $trace->setEndpoint($request->getMethod() . ' ' . $request->getPathInfo());
            if ('GET' !== $method && 'HEAD' !== $method) {
                $trace->setPayload(json_decode($request->getContent(), true) ?? ['failure' => $request->getContent()]);
            } elseif ($request->getQueryString()) {
                parse_str($request->getQueryString(), $query);
                $trace->setPayload($query);
            }
        }

        $user = $this->security->getUser();
        if ($user && $user instanceof User) {
            $trace->setUser($user);
        }

        if (!$this->em->isOpen()) {
            $this->managerRegistry->resetManager(); // Have to reset entity on exception
        }

        $this->em->persist($trace);
        $this->em->flush();

        return $trace;
    }
}
