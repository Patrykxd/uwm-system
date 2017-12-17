<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Providers;

/**
 * Description of XmlParserProvider
 *
 * @author Patryk
 */
class XmlParserProvider {

    public function parse($payload) {
        if ($payload) {
            try {
                $xml = simplexml_load_string($payload, 'SimpleXMLElement', (LIBXML_VERSION >= 20700) ? (LIBXML_PARSEHUGE | LIBXML_NOCDATA) : LIBXML_NOCDATA);
                $ns = ['' => null] + $xml->getDocNamespaces(true);
                return $this->recursive_parse($xml, $ns);
            } catch (\Exception $ex) {
                throw new \Exception('Failed To Parse XML');
            }
        }
        return [];
    }

    protected function recursive_parse($xml, $ns) {
        $xml_string = (string) $xml;
        if ($xml->count() == 0 and $xml_string != '') {
            if (count($xml->attributes()) == 0) {
                if (trim($xml_string) == '') {
                    $result = null;
                } else {
                    $result = $xml_string;
                }
            } else {
                $result = array('#text' => $xml_string);
            }
        } else {
            $result = null;
        }
        foreach ($ns as $nsName => $nsUri) {
            foreach ($xml->attributes($nsUri) as $attName => $attValue) {
                if (!empty($nsName)) {
                    $attName = "{$nsName}:{$attName}";
                }
                $result["@{$attName}"] = (string) $attValue;
            }
            foreach ($xml->children($nsUri) as $childName => $child) {
                if (!empty($nsName)) {
                    $childName = "{$nsName}:{$childName}";
                }
                $child = $this->recursive_parse($child, $ns);
                if (is_array($result) and array_key_exists($childName, $result)) {
                    if (is_array($result[$childName]) and is_numeric(key($result[$childName]))) {
                        $result[$childName][] = $child;
                    } else {
                        $temp = $result[$childName];
                        $result[$childName] = [$temp, $child];
                    }
                } else {
                    $result[$childName] = $child;
                }
            }
        }
        return $result;
    }

}
