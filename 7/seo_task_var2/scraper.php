<?php

require 'vendor/autoload.php';


class Scraper {

    public $doc, $xpath;

    public function __construct($url) {
        $httpClient = new \GuzzleHttp\Client();
        try {
            $response = $httpClient->get($url);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            echo "REQUEST ERROR: " . $e->getMessage();
            die(1);
        }
        $htmlString = (string) $response->getBody();
        libxml_clear_errors();
        libxml_use_internal_errors(true);
        $this->doc = new DOMDocument();
        $this->doc->loadHTML($htmlString);
        $this->xpath = new DOMXPath($this->doc);
    }

    public function query($q) {
        $result = $this->xpath->query($q);
        return $result;
    }

    public function getTextContents($result) {
        $extracted = [];
        foreach ($result as $node) {
            $extracted[] = trim($node->textContent);
        }
        return $extracted;
    }

    public function preview($results) {
        echo "<pre>";
        print_r($results);
        echo "<br> Node Values <br>";
        $arr = array();
        foreach ($results as $result) {
            echo trim($result->nodeValue) . "<br>";
            $arr[] = $result;
        }
        echo "<br> Nodes Array <br>";
        print_r($arr);
        echo "</pre>";
    }
}