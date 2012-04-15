<?php

class PMF_Tournament
{
    /**
     *
     * The database handler
     *
     * @var  object  PMF_Db
     */
    private $db = null;


    public function __construct()
    {
        $this->db = PMF_Db::getInstance();
    }


    public function addTournament(Array $tournament_data, $id = null)
    {
        if (!is_array($tournament_data)) {
            return false;
        }

        // If we only need a new language, we don't need a new category id
        if (is_null($id)) {
            $id = $this->db->nextId(SQLPREFIX . 't_tournaments', 'id');
        }

        $query = sprintf("
            INSERT INTO
                %st_tournaments
            (id, name, description)
                VALUES
            (%d, '%s', '%s')",
            SQLPREFIX,
            $id,
            $tournament_data['name'],
            $tournament_data['description']);
        $this->db->query($query);

        return $id;
    }
}
