<?php

namespace Digbang\DoctrineExtensions\Types;

use Cake\Chronos\Chronos;
use DateTimeImmutable;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeImmutableType;

class ChronosDateTimeType extends DateTimeImmutableType
{
    const CHRONOS_DATETIME = 'chronos_datetime';

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?DateTimeImmutable
    {
        $dateTime = parent::convertToPHPValue($value, $platform);

        return $dateTime === null ? null : Chronos::instance($dateTime);
    }
}
