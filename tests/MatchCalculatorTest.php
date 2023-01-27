<?php

namespace Tests;

use Lentex\Gaudigame\Engine\DefaultCalculationModel;
use Lentex\Gaudigame\Engine\MatchCalculator;

beforeEach(function () {
    $this->matchCalculator = new MatchCalculator(new DefaultCalculationModel());
});

it('processes no guess', function () {
    $evaluatedResult = $this->matchCalculator->process(getScore(3, 1))->get();

    expect($evaluatedResult)
        ->toBeNoGuess()
        ->toHaveNoBoost();
});

it('processes home win', function () {
    $homeWinScore = getScore(3, 1);

    // exact
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(3, 1))->get();

    expect($evaluatedResult)
        ->toBeExactGuess()
        ->toHaveNoBoost();

    // wrong
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(1, 3))->get();

    expect($evaluatedResult)
        ->toBeWrongGuess()
        ->toHaveNoBoost();

    // exact gap
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(2, 0))->get();

    expect($evaluatedResult)
        ->toBeExactGapGuess()
        ->toHaveNoBoost();

    // correct tendency
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(1, 0))->get();

    expect($evaluatedResult)
        ->toBeCorrectTendencyGuess()
        ->toHaveNoBoost();
});

it('processes draw', function () {
    $homeWinScore = getScore(2, 2);

    // exact
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(2, 2))->get();

    expect($evaluatedResult)
        ->toBeExactGuess()
        ->toHaveNoBoost();

    // wrong
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(1, 3))->get();

    expect($evaluatedResult)
        ->toBeWrongGuess()
        ->toHaveNoBoost();

    // draw gap
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(1, 1))->get();

    expect($evaluatedResult)
        ->toBeDrawGapGuess()
        ->toHaveNoBoost();

    // draw gap
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(3, 3))->get();

    expect($evaluatedResult)
        ->toBeDrawGapGuess()
        ->toHaveNoBoost();
});

it('processes away win', function () {
    $homeWinScore = getScore(1, 3);

    // exact
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(1, 3))->get();

    expect($evaluatedResult)
        ->toBeExactGuess()
        ->toHaveNoBoost();

    // wrong
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(3, 1))->get();

    expect($evaluatedResult)
        ->toBeWrongGuess()
        ->toHaveNoBoost();

    // exact gap
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(0, 2))->get();

    expect($evaluatedResult)
        ->toBeExactGapGuess()
        ->toHaveNoBoost();

    // correct tendency
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(0, 1))->get();

    expect($evaluatedResult)
        ->toBeCorrectTendencyGuess()
        ->toHaveNoBoost();
});

test('boosting', function () {
    $homeWinScore = getScore(1, 3);

    // exact with boost
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(1, 3))->boost(1.5)->get();

    expect($evaluatedResult)
        ->toBeExactGuess(1.5)
        ->toHaveBoost();

    // wrong with boost
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(3, 1))->boost(1.5)->get();

    expect($evaluatedResult)
        ->toBeWrongGuess()
        ->toHaveBoost();

    // exact gap with boost
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(0, 2))->boost(1.5)->get();

    expect($evaluatedResult)
        ->toBeExactGapGuess(1.5)
        ->toHaveBoost();

    // correct tendency with boost
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(0, 1))->boost(1.5)->get();

    expect($evaluatedResult)
        ->toBeCorrectTendencyGuess(1.5)
        ->toHaveBoost();

    // exact with double boost (double boost has no effect as it is overwritten
    $evaluatedResult = $this->matchCalculator->process($homeWinScore, getScore(1, 3))->boost(1.5)->boost(1.5)->get();

    expect($evaluatedResult)
        ->toBeExactGuess(1.5)
        ->toHaveBoost();
});
