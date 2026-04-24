<?php

namespace Digbang\DoctrineExtensions\Types;

use Cake\Chronos\Chronos;
use DateTimeImmutable;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeTzImmutableType;

class ChronosDateTimeTzType extends DateTimeTzImmutableType
{
    const CHRONOS_DATETIMETZ = 'chronos_datetimetz';

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?DateTimeImmutable
    {
        $dateTime = parent::convertToPHPValue($value, $platform);

        return $dateTime === null ? null : Chronos::instance($dateTime);
    }
}
