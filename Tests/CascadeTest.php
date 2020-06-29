<?php

use Devshed\Cascade\Cascade;
use Devshed\Cascade\Exceptions\MethodNotFoundException;
use Devshed\Cascade\Utils\InvalidMethodClass;
use Devshed\Cascade\Utils\ToLower;
use Devshed\Cascade\Utils\UcFirst;

it('accepts an input', function () {
    assertEquals('devshed', Cascade::send('devshed')->output());
});

it('can add a class to the cascade', function () {
    $cascade = new Cascade('devshed');

    $cascade->over(UcFirst::class);

    assertContains(UcFirst::class, $cascade->levels);
});

it('executes levels in cascade', function () {
    $cascade = Cascade
        ::send('devshed')
        ->over(UcFirst::class)
        ->over(ToLower::class)
        ->run();

    assertEquals('devshed', $cascade->output());
});

it('raises an error when no cascade method is found', function () {
    $this->expectException(MethodNotFoundException::class);

    Cascade
        ::send('devshed')
        ->over(InvalidMethodClass::class)
        ->run();
});

