<?php

namespace Lentex\Gaudigame\Engine;

class DefaultCalculationModel implements CalculationModel
{
    public function getPointsForExactGuess(): int
    {
        return 3;
    }

    public function getPointsForExactGap(): int
    {
        return 2;
    }

    public function getPointsForDrawGap(): int
    {
        return 1;
    }

    public function getPointsForTendency(): int
    {
        return 1;
    }

    public function getPointsForWrongGuess(): int
    {
        return 0;
    }

    public function getPointsForNoGuess(): int
    {
        return 0;
    }
}