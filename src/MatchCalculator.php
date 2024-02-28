<?php

declare(strict_types=1);

namespace Lentex\Gaudigame\Engine;

use Lentex\Gaudigame\Engine\Contracts\CalculationModel;
use Lentex\Gaudigame\Engine\Contracts\Score;

final class MatchCalculator
{
    private const float DEFAULT_POINTS = 0.0;
    private const float DEFAULT_BOOST = 1.0;

    private float $points = self::DEFAULT_POINTS;
    private float $boost = self::DEFAULT_BOOST;
    private EvaluatedResult $evaluatedResult;
    private Score $result;
    private Score $guess;

    public function __construct(private readonly CalculationModel $calculationModel)
    {
        $this->evaluatedResult = new EvaluatedResult();
    }

    public function process(Score $result, Score $guess = new NoScore()): MatchCalculator
    {
        $this->reset();
        $this->result = $result;
        $this->guess = $guess;

        if (! $guess->canBeEvaluated()) {
            $this->evaluatedResult->setToNo();
            $this->raisePoints($this->calculationModel->getPointsForNoGuess());
            return $this;
        }

        if ($this->isExactGuess()) {
            $this->evaluatedResult->setToExact();
            $this->raisePoints($this->calculationModel->getPointsForExactGuess());
            return $this;
        }

        if ($this->isExactGap()) {
            $this->evaluatedResult->setToGap();
            if ($this->isDrawGap()) {
                $this->raisePoints($this->calculationModel->getPointsForDrawGap());
            } else {
                $this->raisePoints($this->calculationModel->getPointsForExactGap());
            }
            return $this;
        }

        if ($this->isCorrectTendency()) {
            $this->evaluatedResult->setToTendency();
            $this->raisePoints($this->calculationModel->getPointsForTendency());
            return $this;
        }

        $this->evaluatedResult->setToWrong();
        $this->raisePoints($this->calculationModel->getPointsForWrongGuess());

        return $this;
    }

    public function boost(float $factor): MatchCalculator
    {
        $this->boost = $factor;
        $this->evaluatedResult->setBoost();
        return $this;
    }

    public function get(): EvaluatedResult
    {
        $this->points = $this->points * $this->boost;
        $this->evaluatedResult->setPoints($this->points);
        return $this->evaluatedResult;
    }

    private function reset(): void
    {
        $this->points = self::DEFAULT_POINTS;
        $this->boost = self::DEFAULT_BOOST;
        $this->evaluatedResult = new EvaluatedResult();
    }

    private function raisePoints(int $points): void
    {
        $this->points += $points;
    }

    private function isExactGuess(): bool
    {
        return $this->hasSameHome() && $this->hasSameAway();
    }

    private function isExactGap(): bool
    {
        return $this->hasSameMargin();
    }

    private function isDrawGap(): bool
    {
        return $this->hasSameMargin() && $this->isDrawForBoth();
    }

    private function isCorrectTendency(): bool
    {
        if ($this->isHomeWinForBoth()) {
            return true;
        }

        if ($this->isAwayWinForBoth()) {
            return true;
        }

        return false;
    }

    private function hasSameMargin(): bool
    {
        return $this->result->margin() === $this->guess->margin();
    }

    private function isHomeWinForBoth(): bool
    {
        return $this->result->isHomeWin() && $this->guess->isHomeWin();
    }

    private function isAwayWinForBoth(): bool
    {
        return $this->result->isAwayWin() && $this->guess->isAwayWin();
    }

    private function isDrawForBoth(): bool
    {
        return $this->result->isDraw() && $this->guess->isDraw();
    }

    private function hasSameHome(): bool
    {
        return $this->result->home() === $this->guess->home();
    }

    private function hasSameAway(): bool
    {
        return $this->result->away() === $this->guess->away();
    }
}
