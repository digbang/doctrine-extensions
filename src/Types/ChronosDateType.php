<?php

namespace Digbang\DoctrineExtensions\Types;

use Cake\Chronos\Date;
use DateTimeImmutable;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateImmutableType;

class ChronosDateType extends DateImmutableType
{
    const CHRONOS_DATE = 'chronos_date';

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?DateTimeImmutable
    {
        $dateTime = parent::convertToPHPValue($value, $platform);

        return $dateTime === null ? null : Date::instance($dateTime);
    }
}
