<?php

namespace App\Twig;

use DateTime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AgeReturnExtension extends AbstractExtension
{
    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('age_return', [$this, 'ageReturn']),
        ];
    }

    public function ageReturn(DateTime $value): string
    {
        $age = date_diff($value, date_create(date("Y")));

        return $age->format("%y");
    }
}
