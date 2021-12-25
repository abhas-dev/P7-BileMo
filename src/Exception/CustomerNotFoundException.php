<?php

namespace App\Exception;

use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use Throwable;

class CustomerNotFoundException extends \RuntimeException
{
    public function __construct(int $id)
    {
        parent::__construct($message = "L'utilisateur $id n'existe pas");
    }
}