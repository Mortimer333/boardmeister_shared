<?php

declare(strict_types=1);

namespace Shared\Tests;

use Symfony\Component\HttpClient\Response\MockResponse;

abstract class ClientMock
{
    /** @var MockResponse[] $responses */
    protected static array $responses = [];

    abstract public static function getBase(): string;

    public function __call($name, $arguments)
    {
        return $this->base->$name(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return forward_static_call([static::getBase(), $name], ...$arguments);
    }

    public static function setResponses(array $responses): void
    {
        static::$responses = $responses;
    }

    public static function addResponse(MockResponse $response): void
    {
        static::$responses[] = $response;
    }

    public static function clearResponses(): void
    {
        static::$responses = [];
    }

    /**
     * @return MockResponse[]
     */
    public static function getResponses(): array
    {
        return static::$responses;
    }
}
