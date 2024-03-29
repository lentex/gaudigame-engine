<?php

declare(strict_types=1);

namespace Lentex\Gaudigame\Engine\Contracts;

interface CalculationModel
{
    public function getPointsForExactGuess(): int;
    public function getPointsForExactGap(): int;
    public function getPointsForDrawGap(): int;
    public function getPointsForTendency(): int;
    public function getPointsForWrongGuess(): int;
    public function getPointsForNoGuess(): int;
}
