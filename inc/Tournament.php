<?php

class PMF_Tournament
{
    private $id;
    private $name;
    private $description;
    private $players;

    public function __construct($name, $description, $players)
    {
        $this->name = $name;
        $this->description = $description;
        $this->players = $players;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }
}
