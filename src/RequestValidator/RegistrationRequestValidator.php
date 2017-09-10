<?php

namespace EventRegistration\RequestValidator;

use Symfony\Component\HttpFoundation\Request;
use Valitron\Validator;

class RegistrationRequestValidator implements RequestValidatorInterface
{
    /**
     * @var Validator
     */
    private $validator;

    /**
     * RegistrationRequestValidator constructor.
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @inheritdoc
     */
    public function validate(Request $request) : bool
    {
        $this->validator = $this->validator->withData($request->get('event'));

        $this->validator->rule('required', ['salutation', 'forename', 'surname', 'birthdate', 'phone', 'workshops', 'email', 'password']);
        $this->validator->rule('integer', ['workshops']);
        $this->validator->rule('min', 'workshops', 0);
        $this->validator->rule('email', ['email']);
        $this->validator->rule('date', ['birtdate']);
        $this->validator->labels(array(
            'salutation' => 'Salutation',
            'firstname' => 'Forename',
            'surname' => 'Surname',
            'birthdate' => 'Date of Birth',
            'phone' => 'Telephone Number',
            'workshops' => 'Workshops to attend',
            'email' => 'Email Address',
            'password' => 'Password'
        ));

        return $this->validator->validate();
    }

    /**
     * @inheritdoc
     */
    public function getValidatedData(): array
    {
        return $this->validator->data();
    }

    /**
     * @inheritdoc
     */
    public function getValidationErrors() : array
    {
        return $this->validator->errors();
    }
}
