<?php

namespace Zhivkov\SedImplementation\Console;

use Illuminate\Console\Command;

class Sed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sed:substitution  {--search=} {--replace=} {--file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        /**
         * get options
         */
        $file = $this->option('file');
        $replace = $this->option('replace');
        $search = $this->option('search');


        /**
         * Validate if file exists and has permission ro write
         */
        $this->validateFile($file);

        /**
         * execute command
         */
        exec("sed -i 's/".$search."/".$replace."/' ". $file);
    }

    protected function validateFile($file) :void
    {
        if (!file_exists($file)) {
            die($file.' not exists');
        }

        if (!is_writable($file)){
            die($file.' id not writable');
        }
    }

}
