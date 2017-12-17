<?php

namespace App\Providers;

class HtmlParserProvider {

    public function parse($payload) {

        if ($payload) {

            $dom = new \DOMDocument();
            @$dom->loadHTML($payload);

            return $this->selectA($dom);
        }
        return [];
    }

    protected function selectA($dom) {
        $data = array();
        foreach ($dom->getElementsByTagName('a') as $i => $link) {
            $data[] = array(
                'href' => filter_var(trim($link->getAttribute('href')), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH),
                'rel' => filter_var(trim($link->getAttribute('rel')), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH),
                'anchor' => filter_var(trim($link->nodeValue), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH)
            );
        }
        return $data;
    }

}
