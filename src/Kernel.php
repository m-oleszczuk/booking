<?php

declare(strict_types=1);

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    use MicroKernelTrait;

    public function getProjectDir(): string
    {
        return dirname(__DIR__);
    }
}
