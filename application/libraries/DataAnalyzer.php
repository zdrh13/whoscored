<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataAnalyzer
 *
 * @author zdrh
 */
class DataAnalyzer {

    //put your code here
    function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->model('Player_model');
        $this->ci->load->model('Match_model');
    }

    function webData($url) {
        $html2 = file_get_html($url);
        $script = $html2->find('script', 27);
        $jsony = explode("var", $script);
        $promenne = array(
            2 => "matchCentreEventTypeJson",
            3 => "matchId",
            4 => "formationIdNameMappings",
            1 => "matchCentreData"
        );
        unset($jsony[0]);
        foreach ($jsony as $key => $value) {
            if ($key == 3) {
                $zac = strpos($value, "=");
                $kon = strpos($value, ";");
                $string = substr($jsony[$key], $zac + 2, $kon - $zac - 2);
                $data[3] = $string;
            } else {
                $zac = strpos($value, "{");
                $kon = strrpos($value, "}");
                $string = substr($jsony[$key], $zac, $kon - $zac + 1);
                $data[$key] = json_decode($string);
            }
        }
        return $data;
    }
    
   

    function jsonParseMatchCentreData($data, $matchId) {

        $this->addPlayerFromMatch($data->playerIdNameDictionary);
        $this->addAttendance($data->attendance, $matchId);
        $id = $this->testStadium($data->venueName);
        $this->addStadiumToMatch($id, $matchId);
       // $periodMinuteLimits = $data->periodMinuteLimits;
        
        //unset($data->periodMinuteLimits);
        
        $venueName = $data->venueName;
        var_dump($venueName);
        unset($data->venueName);
        $referee = $data->referee;
        unset($data->referee);
        $weatherCode = $data->weatherCode;
        unset($data->weatherCode);
        $startTime = $data->startTime;
        unset($data->startTime);
        $startDate = $data->startDate;
        unset($data->startDate);
        $score = $data->score;
        unset($data->score);
        $htScore = $data->htScore;
        unset($data->htScore);
        $ftScore = $data->ftScore;
        unset($data->ftScore);
        $etScore = $data->etScore;
        unset($data->etScore);
        $pkScore = $data->pkScore;
        unset($data->pkScore);
        $timeStamp = $data->timeStamp;
        unset($data->timeStamp);
        $elapsed = $data->elapsed;
        unset($data->elapsed);
        $statusCode = $data->statusCode;
        unset($data->statusCode);
        $periodCode = $data->periodCode;
        unset($data->periodCode);
        $home = $data->home;
        unset($data->home);
        $away = $data->away;
        unset($data->away);
        $maxMinute = $data->maxMinute;
        unset($data->maxMinute);
        $minuteExpanded = $data->minuteExpanded;
        unset($data->minuteExpanded);
        $maxPeriod = $data->maxPeriod;
        unset($data->maxPeriod);
        $expandedMinutes = $data->expandedMinutes;
        unset($data->expandedMinutes);
        $expandedMaxMinute = $data->expandedMaxMinute;
        unset($data->expandedMaxMinute);
        $periodEndMinutes = $data->periodEndMinutes;
        unset($data->periodEndMinutes);
        $commonEvents = $data->commonEvents;
        unset($data->commonEvents);
        $events = $data->events;
        unset($data->events);
        $timeoutInSeconds = $data->timeoutInSeconds;
        unset($data->timeoutInSeconds);
        echo "<p>";
    }

    function addPlayerFromMatch($data) {
        $result = array();
        foreach ($data as $key => $value) {

            $hrac = array(
                "id" => $key,
                "name" => $value
            );
            $inDB = $this->ci->Player_model->hracInDb($key);
            if (!$inDB) {
                $result[] = $hrac;
            }
        }
        $pocet = count($result);
        if ($pocet != 0) {
            $this->ci->Player_model->vlozitHrace($result);
        }
    }
    
    function testMatch($id) {
        $return = $this->ci->Match_model->matchInDb($id);
        if(!$return) {
            $this->ci->Match_model->addMatch($id);
        }
        
    }
    
    function addAttendance($attendance, $matchId) {
        $this->ci->Match_model->addAttendance($attendance, $matchId);
    }
    
    function testStadium($name) {
        $id = $this->ci->Stadium_model->getStadium($name);
        return  $id;
    }

}
