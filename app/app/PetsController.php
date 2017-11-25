<?php
class PetsController{
    private $db;

    public function __construct($inDB) {
        $this->db = $inDB;
    }
    public function getAll() {
        $data = $this->db->select(
            "Pets",
            "*"
        );

        return $data;
    }

    public function getPetById($pet_id) {
        $data = $this->db->query("SELECT p._id, p.name, p.species, p.favFoods, p.birthYear, p.photo from Pets p
            where p._id = :pet_id",
            [
                "pet_id" => $pet_id
            ])->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function save(Pets $pet) {
        $sql = "insert into pets
            (name, species, favFoods, birthYear, photo) values
            (:name, :species, :favFoods, :birthYear, :photo)";

        $data = $this->db->prepare($sql);
        $result = $data->execute([
            "name" => $pet->getName(),
            "species" => $pet->getSpecies(),
            "favFoods" => $pet->getFavFoods(),
            "birthYear" => $pet->getBirthYear(),
            "photo" => $pet->getPhoto()
        ]);
        if(!$result) {
            throw new Exception("Pet save failed!");
        }
    }
}