<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\MainController;
use App\Tables\SiteTable;
use App\Models\Site;
use App\Http\Validators\SiteValidator;

class SiteController extends MainController{
    public function __construct(){
        $this->frontendRouteFolder = env('FRONTEND_ROUTES',null);
        $this->table = new SiteTable();
        $this->validator = new SiteValidator();
        parent::__construct();
    }

    protected function getFilename(Site $site){
        return $this->frontendRouteFolder.$site->path.'.svelte';
    }

    protected function editOne($site, $editData){
        $site = parent::editOne($site, $editData);

        $filename = $this->getFilename($site);
        //create a svelte file if the file is public but no
        //file is yet created
        if($site->public && !file_exists($filename)){
            $this->createSvelteFile($site);
        }
        //delete the svelte file if the file is not public but a file exists
        if(!$site->public && file_exists($filename)){
            unlink($filename);
        }

        return $site;
    }


    protected function createSvelteFile(Site $site){
        $dirLevel = substr_count($site->path,'/') - 1;
        $correctUrl = '';

        for($i = 0; $i < $dirLevel; $i++) {
            $correctUrl = $correctUrl.'../';
        }

        $file = "<script context=\"module\">
            import Export from '../${correctUrl}components/cms/export.svelte';
            import request from '../${correctUrl}cms/Utils/requests';

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
                const path = page.path;

                const customComponents = await fetchCustomComponents(apiUrl);
                const data = await fetchData(apiUrl, path);

                return { customComponents, data };
            }
            </script>

            <script>
                export let customComponents;
                export let data;
            </script>

            <Export data=\"{data}\" customComponents=\"{customComponents}\" />";

        $filepath = $this->getFilename($site);

        file_put_contents($filepath, $file);
    }

    // in order for the site to export correctly, the index file needs to link to all other sites
    // these links are created here
    protected static function createIndex(){
        $sites = Site::all();
        error_log("sites $sites");
    }
}
