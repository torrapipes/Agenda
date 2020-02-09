<?php
class Agenda {

    // connexió a bbdd
    private $conn;
    private const NOM_TAULA = "agenda";

    // propietats agenda
    private $nom;
    private $tlf;

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Actualitza un contacte o en el cas de no existeixi l'afegeix
     */
    function afegirContacte() {

        try {

            // construim query per insertar el nou contacte
            $query = "INSERT INTO " . self::NOM_TAULA . " (nom, telefon) VALUES (:nom, :tlf) ON DUPLICATE KEY UPDATE telefon=:tlf";

            $stmt = $this->conn->prepare($query);

            // setejam cada parametre
            $stmt->bindParam(":nom", $this->nom);
            $stmt->bindParam(":tlf", $this->tlf);

            $stmt->execute();

        } catch(PDOException $exception){
            echo "Error afegint contacte '" . $this->nom . "': " . $exception->getMessage();
        }

    }

    function borrarContacte() {

        // construim query
        $query = "DELETE FROM " . self::NOM_TAULA . " WHERE nom=:nom";

        $stmt = $this->conn->prepare($query);

        // setejam cada parametre
        $stmt->bindParam(":nom", $this->nom);

        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }


    function llistarContactes() {

        try {
            // construim query
            $query = "SELECT * FROM " . self::NOM_TAULA;

            // no preparam la query perquè no hem fet cap bind
            $stmt = $this->conn->query($query);

            return $stmt;

        } catch (PDOException $ex) {
            echo "Error llistar contactes: " . $ex;
        }


    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getTlf()
    {
        return $this->tlf;
    }

    /**
     * @param mixed $tlf
     */
    public function setTlf($tlf)
    {
        $this->tlf = $tlf;
    }


}
