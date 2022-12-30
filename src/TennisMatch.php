<?php

namespace App;

class TennisMatch
{
    protected Player $playerOne;
    protected Player $playerTwo;

    public function __construct(Player $playerOne, Player $playerTwo)
    {
        $this->playerOne = $playerOne;
        $this->playerTwo = $playerTwo;
    }

    public function score()
    {
        if ($this->hasWinner()) {
            return 'Winner: ' . $this->leader()->name;
        }

        if ($this->hasAdvantage()) {
            return 'Advantage: ' . $this->leader()->name;
        }

        if ($this->isDeuse()) {
            return 'deuce';
        }

        return sprintf(
            "%s-%s",
            $this->playerOne->toTerm(),
            $this->playerTwo->toTerm(),
        );
    }

    protected function hasWinner(): bool
    {
        if (max([$this->playerOne->points, $this->playerTwo->points]) < 4) {
            return false;
        }

        return abs($this->playerOne->points - $this->playerTwo->points) >= 2;
    }

    protected function leader(): Player
    {
        return $this->playerOne->points > $this->playerTwo->points ? $this->playerOne : $this->playerTwo;
    }

    protected function isDeuse()
    {
        return $this->canBeWon() && $this->playerOne->points === $this->playerTwo->points;
    }

    protected function hasAdvantage()
    {
        if ($this->canBeWon()) {
            return !$this->isDeuse();
        }

        return false;
    }

    protected function canBeWon()
    {
        return $this->playerOne->points >= 3 && $this->playerTwo->points >= 3;
    }
}