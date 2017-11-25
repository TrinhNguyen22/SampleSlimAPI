<?php
class  Pets{
    protected $_id;
    protected $name;
    protected $species;
    protected $favFoods;
    protected $birthYear;
    protected $photo;

    public function __construct(array $data){
        // no id if we're creating
        if(isset($data['_id'])) {

            $this->_id = $data['_id'];

        }
            $this->name = $data['name'];
            $this->species = $data['species'];
            $this->favFoods = $data['favFoods'];
            $this->birthYear = $data['birthYear'];
            $this->photo = $data['photo'];
    }
    public function getId() {
        return $this->_id;
    }
    public function getName() {
        return $this->name;
    }
    public function getSpecies() {
        return $this->species;
    }
    public function getFavFoods() {
        return $this->favFoods;
    }
    public function getBirthYear() {
        return $this->birthYear;
    }
    public function getPhoto() {
        return $this->photo;
    }
}