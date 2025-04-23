<?php

namespace App\Exceptions;

use Exception;

class DuplicateVariantException extends Exception
{
    public string $codeIdentifier;
    public array $duplicatedValues;

    public function __construct(string $message, array $duplicatedValues = [], string $codeIdentifier = 'duplicate_variant')
    {
        parent::__construct($message);
        $this->duplicatedValues = $duplicatedValues;
        $this->codeIdentifier = $codeIdentifier;
    }

    public function getCodeIdentifier(): string
    {
        return $this->codeIdentifier;
    }

    public function getDuplicatedValues(): array
    {
        return $this->duplicatedValues;
    }
}
