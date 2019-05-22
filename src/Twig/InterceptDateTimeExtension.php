<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/intercept.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class InterceptDateTimeExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'intercept_date_time',
                [
                    $this,
                    'render'
                ],
                [
                    'needs_environment' => true,
                    'is_safe' => [ 'html' ]
                ]
            ),
        ];
    }

    public function render(Environment $environment, \DateTime $datetime = null): string
    {
        return $environment->render(
            'extension/interceptDateTime.html.twig',
            [
                'datetime' => $datetime
            ]
        );
    }

    public function getName(): string
    {
        return 'intercept_date_time';
    }
}
