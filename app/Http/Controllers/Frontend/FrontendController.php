<?php

namespace App\Http\Controllers\Frontend;

use GuzzleHttp\Client;
use App\Http\Controllers\Base\MainController;
use App\Tables\SiteTable;
use App\Models\Site;
use App\Http\Validators\SiteValidator;

class FrontendController extends MainController{


    // commit And Push only runs in production
    protected static function commitAndPush(Site $site, String $action){
        if(config('app.env') === 'local'){
            return;
        }

        $frontendRoutesFolder = env('FRONTEND_ROUTES', null);
        $backendLocation = env('BACKEND_LOCATION', null);
        $gitToken = env('GITHUB_ACCESS_TOKEN', null);
        $gitRepo = env('GITHUB_REPOSITORY', null);

        if($frontendRoutesFolder == null || $backendLocation == null || $gitToken == null || $gitRepo == null){
            return;
        }

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
        shell_exec("git push https://$gitToken@github.com/$gitRepo");

        chdir($backendLocation);
    }

    protected static function dispatchGithubWorkflow() : bool{
        if(config('app.env') === 'local'){
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
