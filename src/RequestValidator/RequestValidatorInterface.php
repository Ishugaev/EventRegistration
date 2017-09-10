<?php

namespace EventRegistration\RequestValidator;

use Symfony\Component\HttpFoundation\Request;

interface RequestValidatorInterface
{
    /**
     * Validates request
     * @param Request $request
     * @return bool
     */
    public function validate(Request $request) : bool;

    /**
     * Returns validated data
     * @return array
     */
    public function getValidatedData(): array;

    /**
     * Returns data errors
     * @return array
     */
    public function getValidationErrors(): array;
}
