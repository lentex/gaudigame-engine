<?php

declare(strict_types=1);

namespace Lentex\Gaudigame\Engine;

use Lentex\Gaudigame\Engine\Contracts\CalculationModel;

final class DefaultCalculationModel implements CalculationModel
{
    private const int EXACT = 3;
    private const int EXACT_GAP = 2;
    private const int DRAW_GAP = 1;
    private const int TENDENCY = 1;
    private const int WRONG = 0;
    private const int NO = 0;

    public function getPointsForExactGuess(): int
    {
        return self::EXACT;
    }

    public function getPointsForExactGap(): int
    {
        return self::EXACT_GAP;
    }

    public function getPointsForDrawGap(): int
    {
        return self::DRAW_GAP;
    }

    public function getPointsForTendency(): int
    {
        return self::TENDENCY;
    }

    public function getPointsForWrongGuess(): int
    {
        return self::WRONG;
    }

    public function getPointsForNoGuess(): int
    {
        return self::NO;
    }
}
