<?php

declare(strict_types=1);

namespace Shared\Service;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class HttpServiceAbstract
{
    public function __construct(
        protected HttpClientInterface $httpClient,
        protected LoggerInterface $logger,
    ) {
    }

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $headers
     */
    protected function request(
        string $method,
        string $endpoint,
        array $params = [],
        array $headers = [],
    ): ResponseInterface {
        try {
            return $this->httpClient->request(
                $method,
                $this->getApiUrl() . $endpoint,
                $this->getOptions($params, $headers)
            );
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage() . ' => ' . $e->getFile() . ' => ' . $e->getLine());
            throw new \Exception('Email was not send', 500);
        }
    }

    /**
     * @return array<string, string>
     */
    protected function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'X-API-KEY' => $_ENV['MAILBABY_API_TOKEN'],
            'User-Agent' => 'BoardMeister',
        ];
    }

    abstract protected function getApiUrl(): string;

    /**
     * @param array<string, mixed> $params
     * @param array<string, mixed> $headers
     *
     * @return array<string, mixed>
     */
    protected function getOptions(array $params, array $headers): array
    {
        $body['headers'] = array_merge($this->getHeaders(), $headers);
        $body['json'] = $params;

        return $body;
    }
}
