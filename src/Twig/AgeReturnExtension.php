<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AgeReturnExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('age_return', [$this, 'ageReturn']),
        ];
    }

    public function ageReturn($value)
    {
        $age = date_diff($value, date_create(date("Y")));

        return $age->format("%y");
    }
}
