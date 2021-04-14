<?php

namespace App\Console\Commands;

use App\Console\Traits\ConvertFilesTrait;
use App\FileClasses\FileFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class ConvertFileInteractive extends Command
{
    use ConvertFilesTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:countries-i';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interactive convert countries-file to csv | xml | json';
    private FileFactory $fileClassFactory;
    private Collection $availableFiles;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->fileClassFactory = new FileFactory();
        $this->availableFiles = collect(\Storage::disk('public')->files('files'))->map(function ($item) {
            return [
                'filepath' => $item,
                'filename' => basename($item),
            ];
        })->pluck('filename', 'filepath');
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->availableFiles->isEmpty()) {
            $this->info('There is no file to convert. Please load files first here: ' . PHP_EOL . route('index'));
            return;
        }
        $inputFile = $this->choice('Choose file to convert: ', $this->availableFiles->values()->toArray());
        $inputFilePath = $this->availableFiles->search($inputFile);
        $outputFileExtension = $this->choice('Choose format to convert: ', ['xml', 'json', 'csv']);
        $outputFileName = \Str::of($this->ask('What will be filename?'))->before('.');
        if (!$outputFileName->length()) {
            $this->error('New filename is necessary.');
        }
        $outputFilePath = 'converted/' . $outputFileName . '.' . $outputFileExtension;
        try {
            $convertedFilePath = $this->convertFileTo($inputFilePath, $outputFilePath, $outputFileExtension);
            $this->info('Success! File converted. URL to brows converted file: ' . PHP_EOL . $convertedFilePath);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
