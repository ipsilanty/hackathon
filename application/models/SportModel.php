<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SportModel extends CI_Model
{

    public function __construct() {
        parent::__construct();
    }

    public function get_teams($team) {
        $query = "SELECT AwayTeam AS Team FROM division WHERE HomeTeam = ? AND FTR = 'H'
                    UNION
                  SELECT HomeTeam AS Team FROM division WHERE AwayTeam = ? AND FTR = 'A'";
        $result = $this->db->query($query, array($team, $team));
        return $result->result();
    }

    public function get_home_v() {
        $query = "SELECT DISTINCT(HomeTeam) AS team, COUNT(HomeTeam) AS cnt
                    FROM division WHERE FTR = 'H'
                    GROUP BY HomeTeam
                    HAVING cnt > 1
                    ORDER BY cnt DESC
                    LIMIT 0,1";
        $result = $this->db->query($query);
        return $result->result()[0];
    }

}