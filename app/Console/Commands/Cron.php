<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Models\Seo\Links;
use App\Providers\HtmlParserProvider;
use App\Console\Commands\CronRobot;

/**
 * Cron controller
 */
class Cron extends Command {

    protected $signature = 'Cron:start';
    protected $description = 'Parsing website';

    public function __construct() {
        parent::__construct();
    }

    public function handle() {

        $this->getUrl();
        echo "\n[" . Date('Y-m-d H:i:s') . "] skanowanie";
    }

    public function getUrl() {
        $links = Links::take(20)->where('status', 0)->get();
        if ($links->count()) {
            foreach ($links as $link) {
                $this->getPage($link);
            }
        } else {
            Links::query()->update(['status' => 0]);
        }
    }

    public function getPage($link) {

        $url = (strpos($link->refersto, 'http') === false ) ? substr($link->url, 0, -1) . $link->refersto : $link->refersto;

        $result = $this->pageConnection($url);


        if ($result['info']['http_code'] == 301) {
            $result = $this->pageConnection($result['info']['redirect_url']);
        }
        if ($result == false) {
            $data['status'] = 1;
            $link->update($data);
            return false;
        }
        $data['server_response'] = $result['info']['http_code'];

        if ($result['info']['http_code'] != 404) {
            if ($result['info']['http_code'] == 200) {

                $hrefRelAnchor = $this->parsePage($result['html']);

                if (count($hrefRelAnchor)) {
                    /**
                     * sprawdza czy istnieje taki projekt jeśli nie to go dodaje
                     * 
                     */
                    // $project = CronRobot::checkProject($result['info']['url'], $link->projects_id);

                    foreach ($hrefRelAnchor as $a) {
                        /**
                         * jesli href i anchor nie sa puste sprawcza czy istnieje taki link
                         * jesli nie to go dodaje
                         *
                         */
                        if (!empty($a['href']) && !empty($a['anchor']) /*&& $project*/) {
                            // CronRobot::checkLink($project, $a);
                        }

                        if ($a['href'] == $link->refersto && $a['anchor'] == $link->anchor) {
                            $data['nofollow'] = $a['rel'] == '' ? 'brak' : (string) $a['rel'];
                            $data['status'] = 1;

                            $link->update($data);
                            break;
                        }
                    }
                }
            }
        }

        $data['status'] = 1;
        $link->update($data);
    }

    private function pageConnection($url) {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
       
        $data['html'] = curl_exec($ch);
        $data['info'] = curl_getinfo($ch);
        if ($data['html'] === false) {
            echo 'Curl error: ' . curl_error($ch);
            return false;
        }
        
        curl_close($ch);
        return $data;
    }

    private function parsePage($html) {

        $code = new HtmlParserProvider();
        return $code->parse($html);
    }

}
