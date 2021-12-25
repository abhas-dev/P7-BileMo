<?php

namespace App\Exception;

class PhoneNotFoundException extends \RuntimeException
{
    public function __construct(int $id)
    {
        parent::__construct($message = "Le produit $id n'existe pas");
    }
}