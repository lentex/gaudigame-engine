<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

use Lentex\Gaudigame\Engine\DefaultCalculationModel;
use Lentex\Gaudigame\Engine\Score;

expect()->extend('toBeNoGuess', function () {
    $this->getPoints()->toEqual((float) (new DefaultCalculationModel())->getPointsForNoGuess())
        ->isExact()->toBeFalse()
        ->isGap()->toBeFalse()
        ->isTendency()->toBeFalse()
        ->isWrong()->toBeFalse()
        ->isNo()->toBeTrue();

    return $this;
});

expect()->extend('toBeExactGuess', function (float $boost = null) {
    $expectedPoints = (float) (new DefaultCalculationModel())->getPointsForExactGuess();
    $expectedPoints = $boost ? $expectedPoints * $boost : $expectedPoints;

    $this->getPoints()->toEqual($expectedPoints)
        ->isExact()->toBeTrue()
        ->isGap()->toBeFalse()
        ->isTendency()->toBeFalse()
        ->isWrong()->toBeFalse()
        ->isNo()->toBeFalse();

    return $this;
});

expect()->extend('toBeWrongGuess', function (float $boost = null) {
    $expectedPoints = (float) (new DefaultCalculationModel())->getPointsForWrongGuess();
    $expectedPoints = $boost ? $expectedPoints * $boost : $expectedPoints;

    $this->getPoints()->toEqual($expectedPoints)
        ->isExact()->toBeFalse()
        ->isGap()->toBeFalse()
        ->isTendency()->toBeFalse()
        ->isWrong()->toBeTrue()
        ->isNo()->toBeFalse();

    return $this;
});

expect()->extend('toBeExactGapGuess', function (float $boost = null) {
    $expectedPoints = (float) (new DefaultCalculationModel())->getPointsForExactGap();
    $expectedPoints = $boost ? $expectedPoints * $boost : $expectedPoints;

    $this->getPoints()->toEqual($expectedPoints)
        ->isExact()->toBeFalse()
        ->isGap()->toBeTrue()
        ->isTendency()->toBeFalse()
        ->isWrong()->toBeFalse()
        ->isNo()->toBeFalse();

    return $this;
});

expect()->extend('toBeCorrectTendencyGuess', function (float $boost = null) {
    $expectedPoints = (float) (new DefaultCalculationModel())->getPointsForTendency();
    $expectedPoints = $boost ? $expectedPoints * $boost : $expectedPoints;

    $this->getPoints()->toEqual($expectedPoints)
        ->isExact()->toBeFalse()
        ->isGap()->toBeFalse()
        ->isTendency()->toBeTrue()
        ->isWrong()->toBeFalse()
        ->isNo()->toBeFalse();

    return $this;
});

expect()->extend('toBeDrawGapGuess', function (float $boost = null) {
    $expectedPoints = (float) (new DefaultCalculationModel())->getPointsForDrawGap();
    $expectedPoints = $boost ? $expectedPoints * $boost : $expectedPoints;

    $this->getPoints()->toEqual($expectedPoints)
        ->isExact()->toBeFalse()
        ->isGap()->toBeTrue()
        ->isTendency()->toBeFalse()
        ->isWrong()->toBeFalse()
        ->isNo()->toBeFalse();

    return $this;
});

expect()->extend('toHaveNoBoost', function () {
    $this->hasBoost()->toBeFalse();

    return $this;
});

expect()->extend('toHaveBoost', function () {
    $this->hasBoost()->toBeTrue();

    return $this;
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function getScore(int $home, int $away): Score
{
    return new Score($home, $away);
}
