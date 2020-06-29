<?php

namespace Devshed\Cascade\Utils;

class ToLower
{
    public function cascade($carry, $cascade)
    {
        return $cascade(strtolower($carry));
    }
}