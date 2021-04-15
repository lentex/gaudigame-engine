<?php

namespace Lentex\Gaudigame\Engine;

interface CalculationModel
{
    public function getPointsForExactGuess(): int;
    public function getPointsForExactGap(): int;
    public function getPointsForDrawGap(): int;
    public function getPointsForTendency(): int;
    public function getPointsForWrongGuess(): int;
    public function getPointsForNoGuess(): int;
}