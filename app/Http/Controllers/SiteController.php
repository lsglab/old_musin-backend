<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
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

    // commit And Push only runs in production
    private static function commitAndPush(Site $site, String $action){
        if(config('app.env') == 'local'){
            return;
        }

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
    }

    private static function deleteFile(Site $site){
        $filename = SiteController::getFilename($site->path);
        $frontendRoutesFolder = env('FRONTEND_ROUTES', null);
        $backendLocation = env('BACKEND_LOCATION', null);

        if(file_exists($filename)){
            unlink($filename);
        }
    }

    private static function createFile(Site $site, String $file){
        $filepath = SiteController::getFilename($site->path);

        file_put_contents($filepath, $file);
    }

    protected function deleteOne($entry){
        if($entry->path === '/index'){
            return;
        }

        parent::deleteOne($entry);

        SiteController::deleteFile($entry);
        SiteController::commitAndPush($entry, "deleted");
        SiteController::dispatchGithubWorkflow();
    }

    protected function editOne($site, $editData){
        if($site->path === '/index' && $editData['path'] != null ){
            unset($editData['path']);
        }

        $site = parent::editOne($site, $editData);

        $filename = SiteController::getFilename($site->path);
        //create a svelte file if the file is public but no
        //file is yet created
        if($site->public && !file_exists($filename)){
            SiteController::createIndexFile();
            SiteController::createSvelteFile($site, '');
            SiteController::commitAndPush($site, "created");
        }
        //delete the svelte file if the file is not public
        if(!$site->public){
            SiteController::createIndexFile();
            SiteController::deleteFile($site);
            SiteController::commitAndPush($site, "deleted");
        }

        SiteController::dispatchGithubWorkflow();
        return $site;
    }

    public static function getFilename(String $sitepath){
         $frontendRoutesFolder = env('FRONTEND_ROUTES', null);
        return $frontendRoutesFolder.$sitepath.'.svelte';
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

<Export data=\"{data}\" customComponents=\"{customComponents}\" />

";

        SiteController::createFile($site, $file);
    }


    public static function createIndexFile() : Site {
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
        SiteController::dispatchGithubWorkflow();
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

    private static function dispatchGithubWorkflow() : bool{
        if(config('app.env') == 'local'){
            return false;
        }

        $url = env('GITHUB_WORKFLOW_URL', null);
        $branch = env('GITHUB_WORKFLOW_BRANCH', null);
        $token = env('GITHUB_ACCESS_TOKEN', null);

        if($url == null || $branch == null || $token == null){
            return false;
        }

        $client = new Client();
        $res = $client->request("POST", $url, [
            "headers" => [
                "Accept" => "application/vnd.github.v3+json",
                "Authorization" => "token $token",
            ],
            "json"=> [
                "ref" => $branch
            ]
        ]);

        error_log($res->getBody());

        if($res->getStatusCode() === 200){
            return true;
        }

        return false;
    }
}
