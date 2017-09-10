<?php

namespace EventRegistration\Entity;

use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

class Voucher extends Entity
{
    protected static $table = 'voucher';

    /**
     * @inheritdoc
     */
    public static function fields()
    {
        return [
            'voucher'  => ['type' => 'string', 'primary' => true],
            'user_id'   => ['type' => 'integer', 'required' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'user' => $mapper->belongsTo($entity, User::class, 'user_id')
        ];
    }
}
