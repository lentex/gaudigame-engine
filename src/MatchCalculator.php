<?php

namespace Lentex\Gaudigame\Engine;

class MatchCalculator
{
    private const DEFAULT_POINTS = 0.0;
    private const DEFAULT_BOOST = 1.0;

    private float $points = self::DEFAULT_POINTS;
    private float $boost = self::DEFAULT_BOOST;
    private CalculationModel $calculationModel;
    private EvaluatedResult $evaluatedResult;
    private Score $result;
    private ?Score $guess;

    public function __construct(CalculationModel $calculationModel)
    {
        $this->calculationModel = $calculationModel;
        $this->evaluatedResult = new EvaluatedResult();
    }

    public function process(Score $result, ?Score $guess): MatchCalculator
    {
        $this->reset();
        $this->result = $result;
        $this->guess = $guess;

        if (is_null($guess)) {
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

    private function reset()
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
        return ($this->result->home() === $this->guess->home()) && ($this->result->away() === $this->guess->away());
    }

    private function isExactGap(): bool
    {
        if ($this->result->margin() === $this->guess->margin()) {
            return true;
        }

        return false;
    }

    private function isDrawGap(): bool
    {
        if (($this->result->margin() === $this->guess->margin()) && $this->result->isDraw() && $this->guess->isDraw()) {
            return true;
        }

        return false;
    }

    private function isCorrectTendency(): bool
    {
        if ($this->result->isHomeWin() && $this->guess->isHomeWin()) {
            return true;
        }

        if ($this->result->isAwayWin() && $this->guess->isAwayWin()) {
            return true;
        }

        if ($this->result->isDraw() && $this->guess->isDraw()) {
            return true;
        }

        return false;
    }
}