<?php


class addObservations_model
{

    private $database_model;

    /**
     * AddObservations_model constructor
     */
    public function __construct()
    {
        $this->database_model = new Database_model();
    }

    public function getSpecieId($specieName, $scientificName, $description) {
        if ($this->database_model->getSpecieID($specieName))
        {
            //this specie exsits in the database
            return $this->database_model->getSpecieID($specieName);
        }
        else
        {
            //this specie is new
            $this->database_model->insertSpecie($specieName,$scientificName,100,$description);
            return $this->database_model->getSpecieID($specieName);
        }
    }

}