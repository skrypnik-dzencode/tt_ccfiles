<?php

namespace App\Console\Commands;

use App\Console\Traits\ConvertFilesTrait;
use App\FileClasses\FileFactory;
use Illuminate\Console\Command;

class ConvertFileInline extends Command
{
    use ConvertFilesTrait;
    /**
     * The name and signature of the console command.
     * php artisan convert:countries --input-file=countries.json --output-file=countries.xml
     * php artisan convert:countries -I countries.json -O countries.xml
     * @var string
     */
    protected $signature = 'convert:countries {--I|input-file= : Input filename to convert} {--O|output-file= : Converted output filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert countries-file to csv | xml | json';
    private FileFactory $fileClassFactory;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->fileClassFactory = new FileFactory();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle(): void
    {
        if (!$this->option('input-file')) {
            $this->error('Input file is missing');
        }
        if (!$this->option('output-file')) {
            $this->error('Output file is missing');
        }
        $inputFilePath = 'files/' . $this->option('input-file');
        $outputFilePath = 'converted/' . $this->option('output-file');
        $outputFileExtension = \Str::after($outputFilePath, '.');
        try {
            $convertedFilePath = $this->convertFileTo($inputFilePath, $outputFilePath, $outputFileExtension);
            $this->info('Success! File converted. URL to brows converted file: ' . PHP_EOL . $convertedFilePath);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
