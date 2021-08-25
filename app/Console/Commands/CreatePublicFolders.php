<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Files;

class CreatePublicFolders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:public_folders';

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
        Files::createFolder($this->getFullPath('public'));
        Files::createFolder($this->getFullPath('public_backup'));
        Files::createFolder($this->getFullPath('public_const'));
    }

    protected function getFullPath($path){
        $cwd = getcwd();
        return $cwd.'/'.$path;
    }
}
