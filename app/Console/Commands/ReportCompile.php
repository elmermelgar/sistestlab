<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ReportCompile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:compile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compila los archivos necesarios para generar reportes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->info('Limpiando directorio...');
            $gitignore = ['reports/.gitignore'];
            $files = array_diff(Storage::files('reports'), $gitignore);
            Storage::delete($files);

            $this->info('Compilando reportes...');
            $jasper = new \JasperPHP\JasperPHP;

            $input_file = app_path('Reports/report.jrxml');
            $compiled_file = storage_path('app/reports/');
            $jasper->compile($input_file, $compiled_file)->execute();

            $this->info('Los archivos para generar los reportes han sido compilados.');
        } catch (Exception $exception) {
            $this->error('Error al compilar los reportes!. ' . $exception->getMessage());
        }
    }
}
