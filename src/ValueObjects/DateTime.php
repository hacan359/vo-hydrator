<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Assert\Assert;

final class DateTime
{

    private ?\DateTimeInterface $dateTime;

    /**
     * Дата со временем.
     *
     * @param \DateTimeInterface|string|int $dateTime Значения времени в любом типе данных: timestamp, объект даты,
     *      строка с представлением даты
     * @param string|null $format если известен формат строки данных, то можно передать этот формат
     * @param \DateTimeZone|null $zone Часовой пояс даты
     *
     * @throws \Exception
     */
    public function __construct($dateTime = null, ?string $format = null, ?\DateTimeZone $zone = null)
    {
        /** @var \DateTimeInterface|null $res */
        $res = $dateTime;

        switch (true) {
            case is_int($dateTime):
                $res = (new \DateTimeImmutable())->setTimestamp($dateTime);
                break;

            case is_string($dateTime) && $format !== null:
                $res = \DateTimeImmutable::createFromFormat($format, $dateTime) ?: null;
                break;

            case is_string($dateTime):
                $res = new \DateTimeImmutable($dateTime);
                break;
        }

        Assert::that($res)
            ->nullOr()
            ->isInstanceOf(\DateTimeInterface::class);

        if (
            $zone instanceof \DateTimeZone
            && $res instanceof \DateTimeInterface
            && method_exists($res, 'setTimezone')
        ) {
            /** @var \DateTimeInterface $res */
            $res = $res->setTimezone($zone);
        }

        $this->dateTime = $res ?: null;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getValue(): \DateTimeInterface
    {
        Assert::that($this->dateTime)
            ->notNull();

        return $this->dateTime;
    }

    /**
     * @return null|\DateTimeInterface
     */
    public function getNullableValue(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getFormattedValue(string $format): string
    {
        Assert::that($this->dateTime)
            ->notNull();

        return $this->dateTime->format($format);
    }

    /**
     * @param string $format
     *
     * @return null|string
     */
    public function getNullableFormattedValue(string $format): ?string
    {
        if ($this->dateTime instanceof \DateTimeInterface) {
            return $this->dateTime->format($format);
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return $this->dateTime === null;
    }
}
