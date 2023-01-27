<?php

namespace Lentex\Gaudigame\Engine\Contracts;

interface Score
{
    public function canBeEvaluated(): bool;

    public function home(): int;

    public function away(): int;

    public function isDraw(): bool;

    public function isHomeWin(): bool;

    public function isAwayWin(): bool;

    public function margin(): int;
}
