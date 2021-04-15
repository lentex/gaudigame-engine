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
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForNoGuess(), $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), false);
        $this->assertEquals($evaluatedResult->isGap(), false);
        $this->assertEquals($evaluatedResult->isTendency(), false);
        $this->assertEquals($evaluatedResult->isWrong(), false);
        $this->assertEquals($evaluatedResult->isNo(), true);
        $this->assertEquals($evaluatedResult->hasBoost(), false);
    }

    public function testProcessHomeWin(): void
    {
        $result = $this->getScore(3, 1);

        $guess = $this->getScore(3, 1);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForExactGuess(), $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), true);
        $this->assertEquals($evaluatedResult->isGap(), false);
        $this->assertEquals($evaluatedResult->isTendency(), false);
        $this->assertEquals($evaluatedResult->isWrong(), false);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), false);

        $guess = $this->getScore(1, 3);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForWrongGuess(), $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), false);
        $this->assertEquals($evaluatedResult->isGap(), false);
        $this->assertEquals($evaluatedResult->isTendency(), false);
        $this->assertEquals($evaluatedResult->isWrong(), true);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), false);


        $guess = $this->getScore(2, 0);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForExactGap(), $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), false);
        $this->assertEquals($evaluatedResult->isGap(), true);
        $this->assertEquals($evaluatedResult->isTendency(), false);
        $this->assertEquals($evaluatedResult->isWrong(), false);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), false);

        $guess = $this->getScore(1, 0);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForTendency(), $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), false);
        $this->assertEquals($evaluatedResult->isGap(), false);
        $this->assertEquals($evaluatedResult->isTendency(), true);
        $this->assertEquals($evaluatedResult->isWrong(), false);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), false);
    }

    public function testProcessDraw(): void
    {
        $result = $this->getScore(2, 2);

        $guess = $this->getScore(2, 2);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForExactGuess(), $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), true);
        $this->assertEquals($evaluatedResult->isGap(), false);
        $this->assertEquals($evaluatedResult->isTendency(), false);
        $this->assertEquals($evaluatedResult->isWrong(), false);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), false);

        $guess = $this->getScore(1, 3);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForWrongGuess(), $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), false);
        $this->assertEquals($evaluatedResult->isGap(), false);
        $this->assertEquals($evaluatedResult->isTendency(), false);
        $this->assertEquals($evaluatedResult->isWrong(), true);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), false);

        $guess = $this->getScore(1, 1);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForDrawGap(), $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), false);
        $this->assertEquals($evaluatedResult->isGap(), true);
        $this->assertEquals($evaluatedResult->isTendency(), false);
        $this->assertEquals($evaluatedResult->isWrong(), false);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), false);

        $guess = $this->getScore(3, 3);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForDrawGap(), $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), false);
        $this->assertEquals($evaluatedResult->isGap(), true);
        $this->assertEquals($evaluatedResult->isTendency(), false);
        $this->assertEquals($evaluatedResult->isWrong(), false);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), false);
    }

    public function testProcessAwayWin(): void
    {
        $result = $this->getScore(1, 3);

        $guess = $this->getScore(1, 3);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForExactGuess(), $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), true);
        $this->assertEquals($evaluatedResult->isGap(), false);
        $this->assertEquals($evaluatedResult->isTendency(), false);
        $this->assertEquals($evaluatedResult->isWrong(), false);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), false);

        $guess = $this->getScore(2, 2);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForWrongGuess(), $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), false);
        $this->assertEquals($evaluatedResult->isGap(), false);
        $this->assertEquals($evaluatedResult->isTendency(), false);
        $this->assertEquals($evaluatedResult->isWrong(), true);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), false);

        $guess = $this->getScore(0, 2);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForExactGap(), $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), false);
        $this->assertEquals($evaluatedResult->isGap(), true);
        $this->assertEquals($evaluatedResult->isTendency(), false);
        $this->assertEquals($evaluatedResult->isWrong(), false);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), false);

        $guess = $this->getScore(0, 1);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->get();
        $this->assertEquals((float) $this->calculationModel->getPointsForTendency(), $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), false);
        $this->assertEquals($evaluatedResult->isGap(), false);
        $this->assertEquals($evaluatedResult->isTendency(), true);
        $this->assertEquals($evaluatedResult->isWrong(), false);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), false);
    }

    public function testBoosting(): void
    {
        $result = $this->getScore(1, 3);

        $guess = $this->getScore(1, 3);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->boost(1.5)->get();
        $this->assertEquals($this->calculationModel->getPointsForExactGuess() * 1.5, $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), true);
        $this->assertEquals($evaluatedResult->isGap(), false);
        $this->assertEquals($evaluatedResult->isTendency(), false);
        $this->assertEquals($evaluatedResult->isWrong(), false);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), true);

        $guess = $this->getScore(2, 2);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->boost(1.5)->get();
        $this->assertEquals($this->calculationModel->getPointsForWrongGuess() * 1.5, $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), false);
        $this->assertEquals($evaluatedResult->isGap(), false);
        $this->assertEquals($evaluatedResult->isTendency(), false);
        $this->assertEquals($evaluatedResult->isWrong(), true);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), true);

        $guess = $this->getScore(0, 2);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->boost(1.5)->get();
        $this->assertEquals($this->calculationModel->getPointsForExactGap() * 1.5, $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), false);
        $this->assertEquals($evaluatedResult->isGap(), true);
        $this->assertEquals($evaluatedResult->isTendency(), false);
        $this->assertEquals($evaluatedResult->isWrong(), false);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), true);

        $guess = $this->getScore(0, 1);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->boost(1.5)->get();
        $this->assertEquals($this->calculationModel->getPointsForTendency() * 1.5, $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), false);
        $this->assertEquals($evaluatedResult->isGap(), false);
        $this->assertEquals($evaluatedResult->isTendency(), true);
        $this->assertEquals($evaluatedResult->isWrong(), false);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), true);

        $guess = $this->getScore(1, 3);
        $evaluatedResult = $this->matchCalculator->process($result, $guess)->boost(1.5)->boost(1.5)->get();
        $this->assertEquals($this->calculationModel->getPointsForExactGuess() * 1.5, $evaluatedResult->getPoints());
        $this->assertEquals($evaluatedResult->isExact(), true);
        $this->assertEquals($evaluatedResult->isGap(), false);
        $this->assertEquals($evaluatedResult->isTendency(), false);
        $this->assertEquals($evaluatedResult->isWrong(), false);
        $this->assertEquals($evaluatedResult->isNo(), false);
        $this->assertEquals($evaluatedResult->hasBoost(), true);
    }

    private function getScore(int $home, int $away): Score
    {
        return new Score($home, $away);
    }
}