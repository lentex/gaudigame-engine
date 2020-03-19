<?php

namespace Lentex\Gaudigame\Engine;

class Score
{
    private int $home;
    private int $away;
    private bool $isDraw = false;
    private bool $isHomeWin = false;
    private bool $isAwayWin = false;
    private int $margin = 0;

    public function __construct(int $home, int $away)
    {
        $this->home = $home;
        $this->away = $away;

        $this->setupCalculationBasis();
    }

    public function home(): int
    {
        return $this->home;
    }

    public function away(): int
    {
        return $this->away;
    }

    public function isDraw(): bool
    {
        return $this->isDraw;
    }

    public function isHomeWin(): bool
    {
        return $this->isHomeWin;
    }

    public function isAwayWin(): bool
    {
        return $this->isAwayWin;
    }

    public function margin(): int
    {
        return $this->margin;
    }

    private function setupCalculationBasis()
    {
        if ($this->home === $this->away) {
            $this->isDraw = true;
        }

        if ($this->home > $this->away) {
            $this->isHomeWin = true;
        }

        if ($this->away > $this->home) {
            $this->isAwayWin = true;
        }

        $this->margin = $this->home - $this->away;
    }
}