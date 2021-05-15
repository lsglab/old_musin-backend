<?php
namespace App\Console\Commands\Utils;

use App\Models\Subject;
use RecursiveIteratorIterator;
use RegexIterator;
use RecursiveDirectoryIterator;

class ClassFinder {

    //This value should be the directory that contains composer.json
    private $appRoot;

    public function __construct(){
        $path = base_path();
        $this->appRoot = $path."/";
    }

    public function getClassesInFolder($path)
    {
        $path = $this->appRoot.$path;
        $fqcns = array();

        $allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        $phpFiles = new RegexIterator($allFiles, '/\.php$/');

        foreach ($phpFiles as $phpFile) {
            $content = file_get_contents($phpFile->getRealPath());
            $tokens = token_get_all($content);
            $namespace = '';
            for ($index = 0; isset($tokens[$index]); $index++) {
                if (!isset($tokens[$index][0])) {
                    continue;
                }
                if (T_NAMESPACE === $tokens[$index][0]) {
                    $index += 2; // Skip namespace keyword and whitespace
                    while (isset($tokens[$index]) && is_array($tokens[$index])) {
                        $namespace .= $tokens[$index++][1];
                    }
                }
                if (T_CLASS === $tokens[$index][0] && T_WHITESPACE === $tokens[$index + 1][0] && T_STRING === $tokens[$index + 2][0]) {
                    $index += 2; // Skip class keyword and whitespace
                    $fqcns[] = $namespace.'\\'.$tokens[$index][1];

                    # break if you have one class per file (psr-4 compliant)
                    # otherwise you'll need to handle class constants (Foo::class)
                    break;
                }
            }
        }

        return $fqcns;
    }

    public function searchForController($controller){
        $classes = $this->getClassesInFolder('app/Http/Controllers');

        foreach($classes as $class){
            $namespace = "App\Http\Controllers\\{$controller}Controller";
            if($class === $namespace){
                return $namespace;
            }
        }

        return "App\Http\Controllers\generated\\{$controller}Controller";

        return false;
    }

    public function searchForModel($model){
        $classes = $this->getClassesInFolder('app/Models');

        foreach($classes as $class){
            error_log("class $class, model: $model");
            $namespace = "App\Models\\{$model}";
            if($class === $namespace){
                return $namespace;
            }
        }

        return "App\Models\generated\\{$model}";

        return false;
    }
}
