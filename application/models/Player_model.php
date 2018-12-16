<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Player_model
 *
 * @author zdrh
 */
class Player_model extends CI_Model{
    //put your code here
    function __construct() {
        parent::__construct();
    }
    
    function vlozitHrace($data) {
        $this->db->insert_batch('player', $data);
        
    }
    /**
     * 
     * @param type $id - id hráče
     * @return boolean - true - je v Db, false - neni v DB
     */
    function hracInDb($id) {
        $this->db->select("id");
        $this->db->from('player');
        $this->db->where('id', $id);
        
        $query = $this->db->get();
        
        $pocet = $query->num_rows();
       
        if($pocet == 0) {
            $return = false;
        } else {
            $return = true;
        }
        return $return;
    }
}
