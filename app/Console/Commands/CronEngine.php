<?php

namespace App\Console\Commands;

use App\Http\Models\Seo\Links;
use App\Providers\HtmlParserProvider;

class CronEngine {

    public function getUrl() {
        $links = Links::take(2)->where('status', 0)->get();
        if ($links->count()) {
            foreach ($links as $link) {
                $this->getPage($link);
            }
        } else {
            Links::query()->update(['status' => 0]);
        }
    }

    public function getPage($link) {
        $result = $this->pageConnection($link->url);

        if ($result['info']['http_code'] == 301) {
            $result = $this->pageConnection($result['info']['redirect_url']);
        }

        $data['server_response'] = $result['info']['http_code'];

        if ($result['info']['http_code'] != 404) {
            if ($result['info']['http_code'] == 200) {
                $hrefRelAnchor = $this->parsePage($result['html']);
                
                if (count($hrefRelAnchor)) {
                    foreach ($hrefRelAnchor as $a) {
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

        curl_close($ch);
        return $data;
    }

    private function parsePage($html) {

        $code = new HtmlParserProvider();
        return $code->parse($html);
    }

}
