<?php

declare(strict_types=1);

arch('strict types')
    ->expect('Lentex\Gaudigame\Engine')
    ->toUseStrictTypes();

arch('contracts')
    ->expect('Lentex\Gaudigame\Engine\Contracts')
    ->toBeInterface();

arch('final')
    ->expect('Lentex\Gaudigame\Engine')
    ->classes()
    ->toBeFinal();
