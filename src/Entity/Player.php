<?php

namespace App\Entity;

class Player
{
    private const PLAY_PLAY_STATUS = 'play';
    private const BENCH_PLAY_STATUS = 'bench';

    private int $number;
    private string $name;
    private string $playStatus;
    private int $inMinute;
    private int $outMinute;
    private int $goals;
    private int $yellowCards;
    private int $redCard;
    private string $position;

    public function __construct(int $number, string $name, string $position)
    {
        $this->number = $number;
        $this->name = $name;
        $this->position = $position;
        $this->playStatus = self::BENCH_PLAY_STATUS;
        $this->inMinute = 0;
        $this->outMinute = 0;
        $this->goals = 0;
        $this->yellowCards = 0;
        $this->redCard = 0;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInMinute(): int
    {
        return $this->inMinute;
    }

    public function getOutMinute(): int
    {
        return $this->outMinute;
    }

    public function getGoals(): int
    {
        return $this->goals;
    }

    public function getYellowCards(): int
    {
        return $this->yellowCards;
    }

    public function getRedCard(): int
    {
        return $this->redCard;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function isPlay(): bool
    {
        return $this->playStatus === self::PLAY_PLAY_STATUS;
    }

    public function getPlayTime(): int
    {
        if (!$this->outMinute) {
            return 0;
        }
        if ($this->inMinute === 1) {
            $this->inMinute--;
        }

        return $this->outMinute - $this->inMinute;
    }

    public function goToPlay(int $minute): void
    {
        $this->inMinute = $minute;
        $this->playStatus = self::PLAY_PLAY_STATUS;
    }

    public function goToBench(int $minute): void
    {
        $this->outMinute = $minute;
        $this->playStatus = self::BENCH_PLAY_STATUS;
    }

    public function addGoal(): void
    {
        $this->goals++;
    }

    public function addYellowCard(): void
    {
        if ($this->yellowCards === 1) {
            $this->addRedCard();
        } else {
            $this->yellowCards++;
        }
    }

    public function addRedCard(): void
    {
        $this->redCard++;
        if ($this->redCard >= 2) {
            throw new \Exception(
                sprintf("Player can't have more than one red card, player %s have %d red cards", $this->name, $this->redCard)
            );
        }
    }
}