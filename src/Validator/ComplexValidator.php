<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\Request;

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

    public function validate(Request $request)
    {
        //@TODO It would be better to use validator by Symfony
        $discountPercent = $request->get('discount_percent');
        $numberOfUses = $request->get('number_of_uses');
        if ($discountPercent === null) {
            $this->errors[] = 'discount_percent value must be set!';
        }
        if ($numberOfUses === null) {
            $this->errors[] = 'number_of_uses value must be set!';
        }
        if (!is_numeric($discountPercent)) {
            $this->errors[] = 'discount_percent value must have a float type!';
        }
        if (!is_numeric($numberOfUses)) {
            $this->errors[] = 'number_of_uses value must have a numeric type!';
        }
    }
}