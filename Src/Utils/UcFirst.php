<?php

namespace Devshed\Cascade\Utils;

class UcFirst
{
    public function cascade($carry, $cascade)
    {
        return $cascade(ucfirst($carry));
    }
}