<?php

namespace EventRegistration\Entity;

use Spot\Entity;

class User extends Entity
{
    protected static $table = 'user';

    /**
     * @inheritdoc
     */
    public static function fields()
    {
        return [
            'id' => [
                'type' => 'integer',
                'primary' => true,
                'autoincrement' => true
            ],
            'salutation' => [
                'type' => 'string',
                'required' => true
            ],
            'forename' => [
                'type' => 'string',
                'required' => true
            ],
            'surname' => [
                'type' => 'string',
                'required' => true
            ],
            'birthdate' => [
                'type' => 'string',
                'required' => true
            ],
            'phone' => [
                'type' => 'string',
                'required' => true
            ],
            'workshops' => [
                'type' => 'integer',
                'required' => true
            ],
            'email' => [
                'type' => 'string',
                'required' => true
            ],
            'password' => [
                'type' => 'string',
                'required' => true
            ],
            'registration_date' => [
                'type' => 'datetime',
                'value' => new \DateTime(),
                'required' => true
            ],
            'visitor_ip' => [
                'type' => 'string',
                'required' => true
            ],
        ];
    }
}