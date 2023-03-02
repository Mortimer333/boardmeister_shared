<?php

declare(strict_types=1);

namespace Shared\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
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
        FormDataPart|array $params = [],
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
            throw new \Exception('Request was not send', 500);
        }
    }

    /**
     * @return array<string, string>
     */
    protected function getHeaders(): array
    {
        return [
            'User-Agent' => 'BoardMeister',
        ];
    }

    abstract protected function getApiUrl(): string;

    /**
     * @param FormDataPart|array<string, mixed> $params
     * @param array<string, mixed>              $headers
     *
     * @return array<string, mixed>
     */
    protected function getOptions(FormDataPart|array $params, array $headers): array
    {
        $body['headers'] = array_merge($this->getHeaders(), $headers);
        if ($params instanceof FormDataPart) {
            $body['body'] = $params->bodyToIterable();
        } else {
            $body['json'] = $params;
        }

        return $body;
    }
}
