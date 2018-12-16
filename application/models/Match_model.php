<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Match_model
 *
 * @author zdrh
 */
class Match_model extends CI_Model {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function matchInDb($id) {
        $this->db->select("id");
        $this->db->from('game');
        $this->db->where('id', $id);
        $query = $this->db->get();

        $pocet = $query->num_rows();
        if($pocet == 0) {
            $return = FALSE;
        } else {
            $return = true;
        }
        
        return $return;
    }

    function addMatch($id) {
        $data = array("id" => $id);
        
        $this->db->insert("game", $data);
    }
    
    function addAttendance($attendance, $id) {
        $data = array(
            'id' => $id,
            'attendance' => $attendance
        );
        $this->db->where('id', $id);
        $this->db->update('game', $data);
    }
    
    function getStadium($stadiumName) {
        $this->db->select('id');
        $this->db->from('stadium');
        $this->db->where('name', $stadiumName);
        
        
    }

}
