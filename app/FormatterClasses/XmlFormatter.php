<?php


namespace App\FormatterClasses;

use SoapBox\Formatter\Formatter;

class XmlFormatter extends BaseFormatter implements FormatterInterface
{
    private const FORMAT = 'xml';

    public function getArrayContent(): array
    {
        $tmpReformItems = $this->getTmpReformItem();
        $formatter = Formatter::make($tmpReformItems, 'array');
        $result = $formatter->toArray();
        if (\Arr::isAssoc($result)) {
            $result = [$result];
        }
        return $result;
    }

    public function toJson(): string
    {
        $tmpReformItems = $this->getTmpReformItem();
        $formatter = Formatter::make($tmpReformItems, 'array');
        return $formatter->toJson();
    }

    public function toXml(): string
    {
        $tmpReformItems = $this->getTmpReformItem();
        $formatter = Formatter::make($tmpReformItems, 'array');
        return $formatter->toXml();
    }

    public function toCsv(): string
    {
        $tmpReformItems = $this->getTmpReformItem();
        $formatter = Formatter::make($tmpReformItems, 'array');
        return str_replace('"', '', $formatter->toCsv());
    }

    private function getTmpReformItem(): array
    {
        $tmpReformItems = Formatter::make($this->content, self::FORMAT)->toArray();
        if (!empty($tmpReformItems)) {
            $tmpReformItems = head($tmpReformItems);
        }
        return $tmpReformItems;
    }
}
