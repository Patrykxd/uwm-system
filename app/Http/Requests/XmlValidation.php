<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XmlValidation {

    private $required = array('project', 'name', 'domain', 'link', 'url', 'pageUrl', 'anchor');

    public static function valid($array) {

        foreach ($array['project'] as $keyp => $project) {
            if (!isset($project['name']) || empty($project['name']))
                continue;

            if (!isset($project['domain']) || empty($project['domain']) || filter_var($link['urlPage'], FILTER_VALIDATE_URL))
                continue;

            if (!isset($project['link']) || empty($project['link']) || !is_array($project['link']))
                continue;


            foreach ($project['link'] as $keyl => $link) {
                if (!isset($link['url']) || empty($link['url']))
                    continue;

                if (!isset($link['urlPage']) || empty($link['urlPage']) || filter_var($link['urlPage'], FILTER_VALIDATE_URL))
                    continue;

                if (!isset($link['anchor']) || empty($link['anchor']))
                    continue;
            }
        }
        return true;
    }

}
