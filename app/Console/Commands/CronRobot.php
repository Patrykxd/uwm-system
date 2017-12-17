<?php

namespace App\Console\Commands;

use App\Http\Models\Seo\Links;
use App\Http\Models\Seo\Projects;
use App\Providers\HtmlParserProvider;

/**
 * CronRobot controller
 */
class CronRobot {

    public static function checkProject($url, $projects_id) {

        $host = parse_url($url);
        if (isset($host['host']) && !empty($host['host'])) {
            $project = Projects::where('project_name', $host['host'])->first();

            if (is_null($project)) {

                $p['groups_id'] = 12; //robot group
                $p['id_user'] = 3; //robot user
                $p['project_name'] = $host['host'];
                $p['project_domain'] = $host['scheme'] == '' ? 'http' : $host['scheme'] . '://' . trim($host['host'], '/') . '/';
                $p['refers_projects_id'] = $projects_id;

                $project = Projects::create($p);
            }

            return $project;
        }
        return false;
    }

    public static function checkLink($project, $a) {

        $l['projects_id'] = $project->id;
        $l['url'] = $project->project_domain;
        $l['refersto'] = $a['href'];
        $l['anchor'] = $a['anchor'];
        $l['server_response'] = 'brak';
        $l['nofollow'] = 'brak';
        $l['status'] = '0';

        $checklink['url'] = $project->project_domain;
        $checklink['refersto'] = $a['href'];
        $checklink['anchor'] = $a['anchor'];

        $link = $project->links()->where($checklink)->first();
        is_null($link) ? $project->links()->create($l) : '';
    }

}
