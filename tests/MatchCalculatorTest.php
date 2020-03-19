<?php

namespace Tests;

use Lentex\Gaudigame\Engine\CalculationModel;
use Lentex\Gaudigame\Engine\DefaultCalculationModel;
use Lentex\Gaudigame\Engine\MatchCalculator;
use Lentex\Gaudigame\Engine\Score;
use PHPUnit\Framework\TestCase;

class MatchCalculatorTest extends TestCase
{
    private MatchCalculator $matchCalculator;
    private CalculationModel $calculationModel;

    protected function setUp(): void
    {
        $this->calculationModel = new DefaultCalculationModel();
        $this->matchCalculator = new MatchCalculator($this->calculationModel);
    }

    public function testProcessNoGuess(): void
    {
        $result = $this->getScore(3, 1);
        $guess = null;
        $points = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForNoGuess(), $points);
    }

    public function testProcessHomeWin(): void
    {
        $result = $this->getScore(3, 1);

        $guess = $this->getScore(3, 1);
        $points = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForExactGuess(), $points);

        $guess = $this->getScore(1, 3);
        $points = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForWrongGuess(), $points);

        $guess = $this->getScore(2, 0);
        $points = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForExactGap(), $points);

        $guess = $this->getScore(1, 0);
        $points = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForTendency(), $points);
    }

    public function testProcessDraw(): void
    {
        $result = $this->getScore(2, 2);

        $guess = $this->getScore(2, 2);
        $points = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForExactGuess(), $points);

        $guess = $this->getScore(1, 3);
        $points = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForWrongGuess(), $points);

        $guess = $this->getScore(1, 1);
        $points = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForExactGap(), $points);

        $guess = $this->getScore(3, 3);
        $points = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForExactGap(), $points);
    }

    public function testProcessAwayWin(): void
    {
        $result = $this->getScore(1, 3);

        $guess = $this->getScore(1, 3);
        $points = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForExactGuess(), $points);

        $guess = $this->getScore(2, 2);
        $points = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForWrongGuess(), $points);

        $guess = $this->getScore(0, 2);
        $points = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForExactGap(), $points);

        $guess = $this->getScore(0, 1);
        $points = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForTendency(), $points);
    }

    public function testBoosting(): void
    {
        $result = $this->getScore(1, 3);

        $guess = $this->getScore(1, 3);
        $points = $this->matchCalculator->process($result, $guess)->boost(1.5)->get();
        $this->assertEquals($this->calculationModel->getPointsForExactGuess() * 1.5, $points);

        $guess = $this->getScore(2, 2);
        $points = $this->matchCalculator->process($result, $guess)->boost(1.5)->get();
        $this->assertEquals($this->calculationModel->getPointsForWrongGuess() * 1.5, $points);

        $guess = $this->getScore(0, 2);
        $points = $this->matchCalculator->process($result, $guess)->boost(1.5)->get();
        $this->assertEquals($this->calculationModel->getPointsForExactGap() * 1.5, $points);

        $guess = $this->getScore(0, 1);
        $points = $this->matchCalculator->process($result, $guess)->boost(1.5)->get();
        $this->assertEquals($this->calculationModel->getPointsForTendency() * 1.5, $points);

        $guess = $this->getScore(1, 3);
        $points = $this->matchCalculator->process($result, $guess)->boost(1.5)->boost(1.5)->get();
        $this->assertEquals($this->calculationModel->getPointsForExactGuess() * 1.5, $points);
    }

    private function getScore(int $home, int $away): Score
    {
        return new Score($home, $away);
    }
}