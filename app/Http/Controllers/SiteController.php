<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\MainController;
use App\Tables\SiteTable;
use App\Models\Site;
use App\Http\Validators\SiteValidator;

class SiteController extends MainController{


    public function __construct(){
        $this->table = new SiteTable();
        $this->validator = new SiteValidator();
        parent::__construct();
    }

    private static function commitAndPush(Site $site, String $action){
        $frontendRoutesFolder = env('FRONTEND_ROUTES', null);
        $backendLocation = env('BACKEND_LOCATION', null);

        chdir($frontendRoutesFolder);

        $currentUser = auth()->user();
        $currentUserEmail = "";

        if($currentUser == null){
            $currentUser = "server";
        } else {
            $currentUserEmail = $currentUser->email;
            $currentUser = $currentUser->name;
        }

        $message = "feat: ".$currentUser." ".$action." site: ".$site->path;
        shell_exec("git add .");
        shell_exec("git -c user.name=\"$currentUser\" -c user.email=\"$currentUserEmail\" commit  -m \"$message\"");
        shell_exec("git push");

        chdir($backendLocation);

        error_log("execution finished");
    }

    private static function deleteFile(Site $site){
        $filename = SiteController::getFilename($site);
        $frontendRoutesFolder = env('FRONTEND_ROUTES', null);
        $backendLocation = env('BACKEND_LOCATION', null);

        if(file_exists($filename)){
            unlink($filename);
        }
    }

    private static function createFile(Site $site, String $file){
        error_log("create File");
        $filepath = SiteController::getFilename($site);

        file_put_contents($filepath, $file);
    }

    protected function deleteOne($entry){
        if($entry->path === '/index'){
            return;
        }

        SiteController::deleteFile($entry);
        SiteController::commitAndPush($entry, "deleted");

        parent::deleteOne($entry);
    }

    protected function editOne($site, $editData){
        if($site->path === '/index' && $editData['path'] != null ){
            unset($editData['path']);
        }

        $site = parent::editOne($site, $editData);

        $filename = SiteController::getFilename($site);
        //create a svelte file if the file is public but no
        //file is yet created
        if($site->public && !file_exists($filename)){
            error_log("hellooo");
            SiteController::createIndexFile();
            SiteController::createSvelteFile($site, '');
            SiteController::commitAndPush($site, "created");
        }
        //delete the svelte file if the file is not public
        if(!$site->public){
            SiteController::deleteFile($site);
        }

        return $site;
    }

    protected static function getFilename(Site $site){
        $frontendRoutesFolder = env('FRONTEND_ROUTES', null);
        return $frontendRoutesFolder.$site->path.'.svelte';
    }


    protected static function createSvelteFile(Site $site, string $customHtml){
        $dirLevel = substr_count($site->path,'/') - 1;
        $correctUrl = '';

        for($i = 0; $i < $dirLevel; $i++) {
            $correctUrl = $correctUrl.'../';
        }

        $file = "<script context=\"module\">
            import Export from '../${correctUrl}components/cms/export.svelte';
            import request from '../${correctUrl}Utils/requests';

            async function fetchCustomComponents(apiUrl) {
                const res = await request(`\${apiUrl}/components?_norelations=true`, 'get', {}, false);

                if (res.status === 200) {
                    return res.data.components;
                }
                return [];
            }

            async function fetchData(apiUrl, path) {
                const res = await request(`\${apiUrl}/sites?path=\${path}`, 'get', {}, false);

                return JSON.parse(res.data.sites[0].blueprint);
            }

            export async function preload(page, session) {
                const apiUrl = session.globals.apiUrl;
                let path = page.path;

                if(path === '/'){
                    path = '/index';
                }

                const customComponents = await fetchCustomComponents(apiUrl);
                const data = await fetchData(apiUrl, path);

                return { customComponents, data };
            }
            </script>

            <script>
                export let customComponents;
                export let data;
            </script>

            $customHtml

            <Export data=\"{data}\" customComponents=\"{customComponents}\" />";

        SiteController::createFile($site, $file);
    }


    public static function createIndexFile() : Site{
        $customHtml = SiteController::createIndexLinks();

        $index = Site::where('path','/index')->get();

        if(count($index) === 0){
            $index = Site::create([
                'path' => '/index',
                'public' => true,
                'blueprint' => json_encode([
                    'componentName' => 'Empty',
                    'id' => 'index',
                    'props' => (object) null,
                    'slot' => true,
                    'blueprint' => (object) null,
                    'children' => [],
                    'childrenTypes' => [],
                ]),
            ]);
        } else {
            $index = $index[0];
        }

        SiteController::createSvelteFile($index, $customHtml);
        return $index;
    }

    public static function seed(){
        $index = SiteController::createIndexFile();
        SiteController::commitAndPush($index, "setup");
    }

    // in order for the site to export correctly, the index file needs to link to all other sites
    // these links are created here
    public static function createIndexLinks(){
        $sites = Site::all();

        $html = '<div style="visibility:hidden;">';

        foreach($sites as $site){
            if($site->path === '/index') continue;

            $html = $html."<a href='$site->path' alt=''>'$site->path'</a>";
        }

        $html = $html."</div>";

        return $html;
    }
}
