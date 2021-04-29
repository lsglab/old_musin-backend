<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subject;
use App\Console\Commands\Utils\GenerateMigration;
use App\Console\Commands\Utils\GenerateModel;
use App\Console\Commands\Utils\GenerateController;

class generate extends Command
{

    private $DIR;
    private $directories = [
        'models' => '/app/Models/generated/',
        'controllers' => '/app/Http/Controllers/generated/',
        'migrations' => '/database/migrations/',
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:subjects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generates the models, controllers and migrations for all subjects';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();

        $this->DIR = getcwd();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->generateDirs();
        $this->deleteMigrations();
        $this->deleteModels();
        $this->deleteControllers();

        $subjects = Subject::where('type','!=','content-manager')->get();

        //$subjects = $this->sortMigrations($subjects);

        foreach($subjects as $i => $subject){
            $this->createMigration($subject,$i);
            $this->createModel($subject);
            $this->createController($subject);
        }
    }

    function createController($subject){
        $fileName = "{$subject->model}Controller";

        $file = GenerateController::run($subject);
        $this->writeToFile($fileName,'controllers',$file);
    }

    function createModel($subject){
        $fileName = "$subject->model";

        $file = GenerateModel::run($subject);
        $this->writeToFile($fileName,'models',$file);
    }

    function createMigration($subject,$i){
        $i = str_pad($i,6,'0',STR_PAD_LEFT);
        // every migration with a 3000 is auto generated
        // i is used to achieve the right order.
        $fileName = "3000_00_00_{$i}_create_{$subject->table}_table";

        $file = GenerateMigration::run($subject);
        $this->writeToFile($fileName,'migrations',$file);
    }

    function deleteControllers(){
        $path = $this->getDirectoryPath('controllers')."*.php";
        $files = glob($path);
        foreach($files as $file){
            unlink($file);
        }
    }

    function deleteMigrations(){
        $path = $this->getDirectoryPath('migrations')."3000_00_00_*.php";
        $files = glob($path);
        foreach($files as $file){
            unlink($file);
        }
    }

    function deleteModels(){
        $path = $this->getDirectoryPath('models')."*.php";
        $files = glob($path);
        foreach($files as $file){
            unlink($file);
        }
    }

    function sortMigrations($subjects){
        $error = true;
        $array = $subjects->all();

        echo "\n---BEFORE---\n";
        $this->printArray($array);

        while($error === true){
            $error = false;
            foreach($array as $currentIndex => $subject){

                $attributes = $subject->attributes->filter(function($value,$key){
                    if($value->custom_primary_key == false){
                        return $value->relation_type === 'has_one' || $value->relation_type === 'belongs_to';
                    } else {
                        return false;
                    }
                });

                foreach($attributes as $attribute){
                    $foreignIndex;
                    $foreign;

                    foreach($array as $j => $value){
                        $value = $array[$j];

                        if($value->id === $attribute->relation){
                            $foreignIndex = $j;
                            $foreign = $value;
                            break;
                        }
                    }

                    if($currentIndex < $foreignIndex){
                        array_splice($array,$foreignIndex,1);
                        array_splice($array,$currentIndex,0,array($foreign));

                        $error = true;
                        break 2;
                    }
                }
            }
        }

        echo "\n---AFTER---\n";
        $this->printArray($array);
        return $array;
    }

    function printArray($array){
        foreach($array as $element){
            $type = gettype($element);
            echo "$element->model \n";
        }
    }

    function generateDirs(){
        foreach($this->directories as $dir){
            $path = $this->DIR.$dir;

            if(!file_exists($path)){
                mkdir($path,0777,true);
            }
        }
    }

    function getDirectoryPath($path){
        return $this->DIR.$this->directories[$path];
    }

    function writeToFile($fileName,$dir,$data){
        $loaction = $this->getDirectoryPath($dir)."$fileName.php";
        file_put_contents($loaction,$data);
    }
}
