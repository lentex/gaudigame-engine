<?php

declare(strict_types=1);

namespace Lentex\Gaudigame\Engine;

use Lentex\Gaudigame\Engine\Contracts\Score;

final class NoScore implements Score
{
    public function home(): int
    {
        return -1;
    }

    public function away(): int
    {
        return -1;
    }

    public function isDraw(): bool
    {
        return false;
    }

    public function isHomeWin(): bool
    {
        return false;
    }

    public function isAwayWin(): bool
    {
        return false;
    }

    public function margin(): int
    {
        return -1;
    }

    public function canBeEvaluated(): bool
    {
        return false;
    }
}
