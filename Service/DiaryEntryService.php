<?php

declare(strict_types=1);

namespace Shared\Service;

use Shared\Entity\DiaryEntry;

class DiaryEntryService
{
    /**
     * @param array<int|array<string>> $pagination
     *
     * @return array<DiaryEntry>
     */
    public function list(array $pagination): array
    {
        return $this->em->getRepository(DiaryEntry::class)->list($pagination);
    }

    public function get(int $diaryEntryId): DiaryEntry
    {
        $diaryEntry = $this->em->getRepository(DiaryEntry::class)->find($diaryEntryId);
        if (!$diaryEntry) {
            throw new \Exception('DiaryEntry with provided ID doesn\'t exist', 400);
        }

        return $diaryEntry;
    }

    /**
     * @return array<string, int|string|array<array<mixed>>|null>
     */
    public function serialize(DiaryEntry $diaryEntry, bool $content = true, bool $polls = true): array
    {
        $entry = [
            "id" => $diaryEntry->getId(),
            "created" => $diaryEntry->getCreated()?->getTimestamp(),
            "updated" => $diaryEntry->getUpdated()?->getTimestamp(),
            "title" => $diaryEntry->getTitle(),
            "overview" => $diaryEntry->getOverview(),
        ];

        if ($content) {
            $entry["content"] = $diaryEntry->getContent();
        }

        if ($polls) {
            $polls = [];

            foreach ($diaryEntry->getPolls() as $poll) {
                $polls[] = $this->pollService->serialize($poll);
            }

            $entry["polls"] = $polls;
        }

        return $entry;
    }
}
