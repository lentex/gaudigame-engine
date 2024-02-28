<?php

declare(strict_types=1);

use Lentex\Gaudigame\Engine\NoScore;

test('public no score methods', function () {
    $score = new NoScore();

    expect($score)
        ->canBeEvaluated()->toBeFalse()
        ->isHomeWin()->toBeFalse()
        ->isDraw()->toBeFalse()
        ->isAwayWin()->toBeFalse()
        ->home()->toEqual(-1)
        ->away()->toEqual(-1)
        ->margin()->toEqual(-1);
});
