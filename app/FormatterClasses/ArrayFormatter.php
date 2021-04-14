<?php


namespace App\FormatterClasses;

use SoapBox\Formatter\Formatter;

class ArrayFormatter extends BaseFormatter implements FormatterInterface
{
    private const FORMAT = 'array';

    public function toJson(): string
    {
        $formatter = Formatter::make($this->content, self::FORMAT);
        return $formatter->toJson();
    }

    public function toXml(): string
    {
        $formatter = Formatter::make($this->content, self::FORMAT);
        return $formatter->toXml();
    }

    public function toCsv(): string
    {
        $formatter = Formatter::make($this->content, self::FORMAT);
        return str_replace('"', '', $formatter->toCsv());
    }

    public function getArrayContent(): array
    {
        return $this->content ?? [];
    }
}
