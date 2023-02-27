<?php

declare(strict_types=1);

namespace Shared\Service;

use Shared\Entity\Internal\Poll;

class PollService
{
    /**
     * @param array<int|array<string>> $pagination
     *
     * @return array<Poll>
     */
    public function list(array $pagination): array
    {
        return $this->em->getRepository(Poll::class)->list($pagination);
    }

    public function get(int $pollId): Poll
    {
        $poll = $this->em->getRepository(Poll::class)->find($pollId);
        if (!$poll) {
            throw new \Exception('Poll with provided ID doesn\'t exist', 400);
        }

        return $poll;
    }

    /**
     * @return array<string, string|array<array<mixed>>|null>
     */
    public function serialize(Poll $poll): array
    {
        $options = [];
        foreach ($poll->getOptions() as $option) {
            $options[] = $this->pollOptionService->serialize($option);
        }

        return [
            'id' => $poll->getId(),
            'title' => $poll->getTitle(),
            'end' => $poll->getEndDate()?->getTimestamp(),
            'options' => $options,
        ];
    }
}
