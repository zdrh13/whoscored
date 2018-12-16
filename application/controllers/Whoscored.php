<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Whoscored extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('dataanalyzer');
    }

    function getMatches() {
        /*
          $html = file_get_html("https://www.whoscored.com/Matches/1294663/Live/Germany-Bundesliga-2018-2019-Werder-Bremen-Fortuna-Duesseldorf");
          $script = $html->find('script');
          foreach ($script as $key => $value) {
          echo "<p>".$key." ".substr($value, 10);
          } */
    }

    function getMatches2() {
        $url = "https://www.whoscored.com/Matches/1294663/Live/Germany-Bundesliga-2018-2019-Werder-Bremen-Fortuna-Duesseldorf";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $html = curl_exec($ch);
        var_dump($html);
        // $data = curl_exec($ch);
        curl_close($ch);
    }

    function getMatches3() {
        /*  $snoopy = new Snoopy();
          $url = "https://www.whoscored.com/Matches/1294663/Live/Germany-Bundesliga-2018-2019-Werder-Bremen-Fortuna-Duesseldorf";
          // read webpage content
          $snoopy->fetch($url);
          // save it to $lines_string
          $html = $snoopy->results;

          $result = file_put_contents('assets/html/stranka.html', $html);
         */
//output, you can also save it locally on the server
        $url = base_url('assets/html/stranka.html');
        $data = $this->dataanalyzer->webData($url);
        $matchId = $data[3];
        
        //přidá zápas, pokud tam už není
        $this->dataanalyzer->testMatch($matchId);
        
        $this->dataanalyzer->jsonParseMatchCentreData($data[1], $matchId);
        
        
        
        //var_dump($data["matchCentreData"]);
    }

}
