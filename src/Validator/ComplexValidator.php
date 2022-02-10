<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\Request;

//@TODO It would be better to use validator by Symfony
class ComplexValidator
{
    private array $errors = [];
    private bool $passed = true;

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isPassed(): bool
    {
        return $this->passed;
    }

    public function validateGeneration(Request $request): self
    {
        $discountPercent = $request->get('discount_percent');
        $numberOfUses = $request->get('number_of_uses');
        if ($discountPercent === null) {
            $this->errors[] = 'discount_percent value must be set!';
            $this->passed = false;
        }
        if ($numberOfUses === null) {
            $this->errors[] = 'number_of_uses value must be set!';
            $this->passed = false;
        }
        if (!is_numeric($discountPercent)) {
            $this->errors[] = 'discount_percent value must have a float type!';
            $this->passed = false;
        }
        if (!is_numeric($numberOfUses)) {
            $this->errors[] = 'number_of_uses value must have a numeric type!';
            $this->passed = false;
        }
        return $this;
    }

    public function validateApplication(Request $request): self
    {
        $keyword = $request->get('keyword');
        if ($keyword === null) {
            $this->errors[] = 'keyword value must must be set!';
            $this->passed = false;
        }
        return $this;
    }
}