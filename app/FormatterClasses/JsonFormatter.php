<?php


namespace App\FormatterClasses;

use SoapBox\Formatter\Formatter;

class JsonFormatter extends BaseFormatter implements FormatterInterface
{
    private const FORMAT = 'json';

    public function getArrayContent(): array
    {
        $formatter = Formatter::make($this->content, self::FORMAT);
        return $formatter->toArray();
    }

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
        return str_replace('"','',$formatter->toCsv());
    }
}
