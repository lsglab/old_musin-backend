<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Files;

class ReplaceFrontend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replace:frontend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';
    protected ?string $frontendExportFolder = null;

    protected string $public_backup;
    protected string $public_const;
    protected string $public;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->public = $this->getFullPath('public/');
        $this->public_backup = $this->getFullPath('public_backup/');
        $this->public_const = $this->getFullPath('public_const/');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->frontendExportFolder = env('FRONTEND_EXPORT',null);

        if($this->frontendExportFolder === null){
            $this->error("No env variable named FRONTEND_EXPORT was found");
        }

        //delete contents of public_backup
        Files::deleteFolder($this->public_backup);
        $this->line('deleted old backup');

        //move current contents of public in the backup folder;
        Files::copyFolder($this->public,$this->public_backup);
        $this->info('New backup made');

        //then delete contents of public folder
        Files::deleteFolder($this->public);
        $this->line('deleted public folder');

        //and move the new frontend files in public
        Files::copyFolder($this->frontendExportFolder,$this->public);
        Files::copyFolder($this->public_const,$this->public);
        //then move the
        $this->info('Successfully exchanged frontend files. It is now neccessary to rebuild all sites in order for the site to function');
    }

    protected function getFullPath($path){
        $cwd = getcwd();
        return $cwd.'/'.$path;
    }
}
