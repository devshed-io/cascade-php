<?php


namespace Devshed\Cascade\Utils;


class InvalidMethodClass
{
    public function run($carry, $cascade)
    {
        return $cascade($carry);
    }
}