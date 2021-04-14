<?php

namespace Tests\Unit;

use App\FileClasses\FileFactory;
use App\FormatterClasses\FormatterFactory;
use App\FormatterClasses\FormatterInterface;
use Illuminate\Http\File;
use Tests\TestCase;

class FileContentTest extends TestCase
{

    /**
     * @var FormatterFactory
     */
    private FormatterFactory $formatterFactory;
    /**
     * @var FileFactory
     */
    private FileFactory $fileClassFactory;

    private string $pathXml;
    private string $pathCsv;
    private string $pathJson;

    private array $files;

    protected function setUp(): void
    {
        parent::setUp();
        \Storage::fake('public');
        $files = [
            'countries.csv' => __DIR__ . '/../Files/countries.csv',
            'countries.json' => __DIR__ . '/../Files/countries.json',
            'countries.xml' => __DIR__ . '/../Files/countries.xml',
        ];
        foreach ($files as $f => $p) {
            $file = new File($p);
            \Storage::disk('public')->putFileAs('/files', $file, $f);
        }
        $this->pathCsv = 'files/countries.csv';
        $this->pathJson = 'files/countries.json';
        $this->pathXml = 'files/countries.xml';

        $this->files = [
            $this->pathCsv,
            $this->pathJson,
            $this->pathXml,
        ];

        $this->formatterFactory = new FormatterFactory();
        $this->fileClassFactory = new FileFactory();
    }

    public function test_get_file_content(): void
    {
        $csvExpectation = 'Country,Capital' . PHP_EOL;
        $csvExpectation .= 'Ukraine,Kyiv' . PHP_EOL;
        $csvExpectation .= 'Germany,Berlin' . PHP_EOL;
        $csvExpectation .= 'USA,Washington' . PHP_EOL;
        $fileClass = $this->fileClassFactory->getFileClassByPath($this->pathCsv);
        self::assertEquals($csvExpectation, $fileClass->getFileContent());
    }

    public function test_formatter_instances(): void
    {
        $formatter = $this->formatterFactory->getFormatterByFilePath($this->pathCsv);
        self::assertInstanceOf(FormatterInterface::class, $formatter);
        $formatter = $this->formatterFactory->getFormatterByFilePath($this->pathJson);
        self::assertInstanceOf(FormatterInterface::class, $formatter);
        $formatter = $this->formatterFactory->getFormatterByFilePath($this->pathXml);
        self::assertInstanceOf(FormatterInterface::class, $formatter);
    }

    public function test_file_formatter_instances(): void
    {
        $formatter = $this->fileClassFactory->getFileClassByPath($this->pathCsv)->getFileFormatter();
        self::assertInstanceOf(FormatterInterface::class, $formatter);
        $formatter = $this->fileClassFactory->getFileClassByPath($this->pathJson)->getFileFormatter();
        self::assertInstanceOf(FormatterInterface::class, $formatter);
        $formatter = $this->fileClassFactory->getFileClassByPath($this->pathXml)->getFileFormatter();
        self::assertInstanceOf(FormatterInterface::class, $formatter);
    }

    public function test_get_formatted_content_via_file(): void
    {
        $fileFormatter = $this->fileClassFactory->getFileClassByPath($this->pathCsv)->formatterStartCondition();
        $expectedCsvToArray = [
            [
                "Country" => "Ukraine",
                "Capital" => "Kyiv",
            ],
            [
                "Country" => "Germany",
                "Capital" => "Berlin",
            ],
            [
                "Country" => "USA",
                "Capital" => "Washington",
            ],
        ];
        self::assertEquals($expectedCsvToArray, $fileFormatter->getArrayContent());

        $fileFormatter = $this->fileClassFactory->getFileClassByPath($this->pathJson)->formatterStartCondition();
        $expectedJsonToArray = [
            [
                "capital" => "Kyiv",
                "country" => "Ukraine",
            ],
            [
                "capital" => "Berlin",
                "country" => "Germany",
            ],
            [
                "capital" => "Washington",
                "country" => "USA",
            ],
        ];
        self::assertEquals($expectedJsonToArray, $fileFormatter->getArrayContent());

        $fileFormatter = $this->fileClassFactory->getFileClassByPath($this->pathXml)->formatterStartCondition();
        $expectedXmlToArray = [
            [
                "country" => "Ukraine",
                "capital" => "Kyiv",
            ],
            [
                "country" => "Germany",
                "capital" => "Berlin",
            ],
            [
                "country" => "USA",
                "capital" => "Washington",
            ],
        ];
        self::assertEquals($expectedXmlToArray, $fileFormatter->getArrayContent());
    }

    public function test_get_formatter_csv_content(): void
    {
        $formatter = $this->formatterFactory->getFormatterByFilePath($this->pathCsv);
        $expectedCsvToArray = [
            [
                "Country" => "Ukraine",
                "Capital" => "Kyiv",
            ],
            [
                "Country" => "Germany",
                "Capital" => "Berlin",
            ],
            [
                "Country" => "USA",
                "Capital" => "Washington",
            ],
        ];
        self::assertEquals($expectedCsvToArray, $formatter->getArrayFormattedContent($this->pathCsv));
    }

    public function test_get_formatter_xml_content(): void
    {
        $formatter = $this->formatterFactory->getFormatterByFilePath($this->pathJson);
        $expectedJsonToArray = [
            [
                "capital" => "Kyiv",
                "country" => "Ukraine",
            ],
            [
                "capital" => "Berlin",
                "country" => "Germany",
            ],
            [
                "capital" => "Washington",
                "country" => "USA",
            ],
        ];
        self::assertEquals($expectedJsonToArray, $formatter->getArrayFormattedContent($this->pathJson));
    }

    public function test_get_formatter_json_content(): void
    {
        $formatter = $this->formatterFactory->getFormatterByFilePath($this->pathXml);
        $expectedXmlToArray = [
            [
                "country" => "Ukraine",
                "capital" => "Kyiv",
            ],
            [
                "country" => "Germany",
                "capital" => "Berlin",
            ],
            [
                "country" => "USA",
                "capital" => "Washington",
            ],
        ];
        self::assertEquals($expectedXmlToArray, $formatter->getArrayFormattedContent($this->pathXml));
    }

    public function test_get_blob_file_content_from_to(): void
    {
        $from = $this->pathCsv;
        $to = 'json';
        $fileClass = $this->fileClassFactory->getFileClassByPath($from);
        $fileFormatter = $fileClass->formatterStartCondition();
        $fileBlob = $fileFormatter->getFormattedFileBlobTo($to);
        $expectedBlob = '[{"Country":"Ukraine","Capital":"Kyiv"},{"Country":"Germany","Capital":"Berlin"},{"Country":"USA","Capital":"Washington"}]';
        self::assertEquals($fileBlob, $expectedBlob);

        $from = $this->pathCsv;
        $to = 'xml';
        $fileClass = $this->fileClassFactory->getFileClassByPath($from);
        $fileFormatter = $fileClass->formatterStartCondition();
        $fileBlob = $fileFormatter->getFormattedFileBlobTo($to);
        $expectedBlob = '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL . '<xml>';
        $expectedBlob .= '<item><Country>Ukraine</Country><Capital>Kyiv</Capital></item>';
        $expectedBlob .= '<item><Country>Germany</Country><Capital>Berlin</Capital></item>';
        $expectedBlob .= '<item><Country>USA</Country><Capital>Washington</Capital></item></xml>' . PHP_EOL;
        self::assertEquals($fileBlob, $expectedBlob);

        $from = $this->pathJson;
        $to = 'csv';
        $fileClass = $this->fileClassFactory->getFileClassByPath($from);
        $fileFormatter = $fileClass->formatterStartCondition();
        $fileBlob = $fileFormatter->getFormattedFileBlobTo($to);
        $expectedBlob = 'country,capital' . PHP_EOL;
        $expectedBlob .= 'Ukraine,Kyiv' . PHP_EOL;
        $expectedBlob .= 'Germany,Berlin' . PHP_EOL;
        $expectedBlob .= 'USA,Washington';
        self::assertEquals($fileBlob, $expectedBlob);

        $from = $this->pathJson;
        $to = 'xml';
        $fileClass = $this->fileClassFactory->getFileClassByPath($from);
        $fileFormatter = $fileClass->formatterStartCondition();
        $fileBlob = $fileFormatter->getFormattedFileBlobTo($to);
        $expectedBlob = '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL . '<xml>';
        $expectedBlob .= '<item><country>Ukraine</country><capital>Kyiv</capital></item>';
        $expectedBlob .= '<item><country>Germany</country><capital>Berlin</capital></item>';
        $expectedBlob .= '<item><country>USA</country><capital>Washington</capital></item></xml>' . PHP_EOL;
        self::assertEquals($fileBlob, $expectedBlob);

        $from = $this->pathXml;
        $to = 'csv';
        $fileClass = $this->fileClassFactory->getFileClassByPath($from);
        $fileFormatter = $fileClass->formatterStartCondition();
        $fileBlob = $fileFormatter->getFormattedFileBlobTo($to);
        $expectedBlob = 'capital,country' . PHP_EOL;
        $expectedBlob .= 'Kyiv,Ukraine' . PHP_EOL;
        $expectedBlob .= 'Berlin,Germany' . PHP_EOL;
        $expectedBlob .= 'Washington,USA';
        self::assertEquals($fileBlob, $expectedBlob);

        $from = $this->pathXml;
        $to = 'json';
        $fileClass = $this->fileClassFactory->getFileClassByPath($from);
        $fileFormatter = $fileClass->formatterStartCondition();
        $fileBlob = $fileFormatter->getFormattedFileBlobTo($to);
        $expectedBlob = '[{"capital":"Kyiv","country":"Ukraine"},{"capital":"Berlin","country":"Germany"},{"capital":"Washington","country":"USA"}]';
        self::assertEquals($fileBlob, $expectedBlob);
    }

    public function test_remove_item_from_csv_file(): void
    {
        $fileClass = $this->fileClassFactory->getFileClassByPath($this->pathCsv);
        $arrItems = $fileClass->formatterStartCondition()->getArrayContent();
        $item = array_shift($arrItems);
        $fileClass->removeItem($item);
        $fileClass->refreshContent();
        self::assertEquals($arrItems, $fileClass->formatterStartCondition()->getArrayContent());

        $item = array_shift($arrItems);
        $fileClass->removeItem($item);
        $fileClass->refreshContent();
        self::assertEquals($arrItems, $fileClass->formatterStartCondition()->getArrayContent());

        $item = array_shift($arrItems);
        $fileClass->removeItem($item);
        $fileClass->refreshContent();
        self::assertEquals($arrItems, $fileClass->formatterStartCondition()->getArrayContent());
    }

    public function test_remove_item_from_json_file(): void
    {
        $fileClass = $this->fileClassFactory->getFileClassByPath($this->pathJson);
        $arrItems = $fileClass->formatterStartCondition()->getArrayContent();
        $item = array_shift($arrItems);
        $fileClass->removeItem($item);
        $fileClass->refreshContent();
        self::assertEquals($arrItems, $fileClass->formatterStartCondition()->getArrayContent());

        $item = array_shift($arrItems);
        $fileClass->removeItem($item);
        $fileClass->refreshContent();
        self::assertEquals($arrItems, $fileClass->formatterStartCondition()->getArrayContent());

        $item = array_shift($arrItems);
        $fileClass->removeItem($item);
        $fileClass->refreshContent();
        self::assertEquals($arrItems, $fileClass->formatterStartCondition()->getArrayContent());

    }

    public function test_remove_item_from_xml_file(): void
    {
        $fileClass = $this->fileClassFactory->getFileClassByPath($this->pathXml);
        $arrItems = $fileClass->formatterStartCondition()->getArrayContent();
        $item = array_shift($arrItems);
        $fileClass->removeItem($item);
        $fileClass->refreshContent();
        self::assertEquals($arrItems, $fileClass->formatterStartCondition()->getArrayContent());

        $item = array_shift($arrItems);
        $fileClass->removeItem($item);
        $fileClass->refreshContent();
        self::assertEquals($arrItems, $fileClass->formatterStartCondition()->getArrayContent());

        $item = array_shift($arrItems);
        $fileClass->removeItem($item);
        $fileClass->refreshContent();
        self::assertEquals($arrItems, $fileClass->formatterStartCondition()->getArrayContent());
    }

    /**
     * @throws \JsonException
     */
    public function test_add_item_to_file(): void
    {
        foreach ($this->files as $filePath) {
            $fileClass = $this->fileClassFactory->getFileClassByPath($filePath);
            $arrItems = $fileClass->formatterStartCondition()->getArrayContent();
            $newItem = json_decode('[]', true, 512, JSON_THROW_ON_ERROR);
            if (empty($newItem)) {
                $newItem = $fileClass->getCloneFileItem();
            }
            $arrItems[] = $newItem;
            $fileClass->addItem($newItem);
            $fileClass->refreshContent();
            self::assertEquals($arrItems, $fileClass->formatterStartCondition()->getArrayContent());
        }
    }

    public function test_update_file_item(): void
    {
        $index = 1;
        $itemCsv = [
            'Country' => 'updated-Cn',
            'Capital' => 'updated-Cp',
        ];
        $fileClass = $this->fileClassFactory->getFileClassByPath($this->pathCsv);
        $arrItems = $fileClass->formatterStartCondition()->getArrayContent();
        $arrItems[$index] = $itemCsv;
        $fileClass->updateItem($itemCsv, $index);
        $fileClass->refreshContent();
        self::assertEquals($arrItems, $fileClass->formatterStartCondition()->getArrayContent());

        $itemJson = [
            'country' => 'updated-cn',
            'capital' => 'updated-cp',
        ];
        $fileClass = $this->fileClassFactory->getFileClassByPath($this->pathJson);
        $arrItems = $fileClass->formatterStartCondition()->getArrayContent();
        $arrItems[$index] = $itemJson;
        $fileClass->updateItem($itemJson, $index);
        $fileClass->refreshContent();
        self::assertEquals($arrItems, $fileClass->formatterStartCondition()->getArrayContent());
        $itemXml = [
            'capital' => 'updated-CP',
            'country' => 'updated-CP',
        ];
        $fileClass = $this->fileClassFactory->getFileClassByPath($this->pathXml);
        $arrItems = $fileClass->formatterStartCondition()->getArrayContent();
        $arrItems[$index] = $itemXml;
        $fileClass->updateItem($itemXml, $index);
        $fileClass->refreshContent();
        self::assertEquals($arrItems, $fileClass->formatterStartCondition()->getArrayContent());


    }
}
