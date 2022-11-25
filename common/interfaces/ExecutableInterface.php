<?php
declare(strict_types=1);

namespace common\interfaces;

interface ExecutableInterface
{
    public function execute(): bool;
}