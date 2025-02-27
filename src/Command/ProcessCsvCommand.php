<?php
namespace App\Command;

use App\Service\CsvProcessor;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:process-csv',
    description: 'Import subscribers from a CSV file.'
)]
class ProcessCsvCommand extends Command
{
    private CsvProcessor $csvProcessor;

    public function __construct(CsvProcessor $csvProcessor)
    {
        parent::__construct();
        $this->csvProcessor = $csvProcessor;
    }

    protected function configure(): void
    {
        $this->addArgument('filePath', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $startTime = microtime(true);
        $filePath = $input->getArgument('filePath');

        if (!file_exists($filePath)) {
            $output->writeln('File not found: ' . $filePath);
            return Command::FAILURE;
        }

        $this->csvProcessor->processCsv($filePath);
        $executionTime = microtime(true) - $startTime;
        $output->writeln('CSV añadido correctamente');
        $output->writeln('Tiempo de ejecución: ' . $executionTime . ' segundos');
        return Command::SUCCESS;
    }
}
