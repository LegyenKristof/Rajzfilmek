<?php

namespace Korcsmaroskristof\Rajzfilmek;

use Exception;

class Rajzfilm{
    public $id;
    public $cim;
    public $hossz;
    public $kiadasi_ev;
    
    public function setAttributes(array $attr) {
        $this->id = $attr['id'] ?? $this->id;
        $this->cim = $attr['cim'] ?? $this->cim;
        $this->hossz = $attr['hossz'] ?? $this->hossz;
        $this->kiadasi_ev = $attr['kiadasi_ev'] ?? $this->kiadasi_ev;
    }

    public function torles(){
        if($this->id == null){
            throw new Exception("null ID");
        }

        global $db;

        $stmt = $db->prepare("DELETE FROM rajzfilmek WHERE id = :id");
        $stmt->execute([":id" => $this->id]);

        if($stmt->rowCount() != 1){
            throw new Exception("Nincs ilyen rekord");
        }         
    }

    public static function getById(int $id) : ?Rajzfilm {
        global $db;
        $stmt = $db->prepare("SELECT * FROM rajzfilmek WHERE id = :id");
        $stmt->execute([":id" => $id]);
        if($stmt->rowCount() != 1){
            return null;
        }
        $rajzfilm = new Rajzfilm();
        $rajzfilm->setAttributes($stmt->fetchAll()[0]);
        return $rajzfilm;
    }

    public static function osszes() : array {
        global $db;
        $result = $db->query("SELECT * FROM rajzfilmek")
            ->fetchAll();
        $rajzfilmek = [];
        foreach($result as $elem){
            $rajzfilm = new Rajzfilm();
            $rajzfilm->setAttributes($elem);
            $rajzfilmek[] = $rajzfilm;
        }
        return $rajzfilmek;
    }

    public function uj() {
        global $db;
        $stmt = $db->prepare("INSERT INTO rajzfilmek (cim, hossz, kiadasi_ev) VALUES (:cim, :hossz, :kiadasi_ev)")
            ->execute([
                ":cim" =>  $this->cim,
                ":hossz" =>  $this->hossz,
                ":kiadasi_ev" =>  $this->kiadasi_ev,
            ]);
        
        $this->id = $db->lastInsertId();
    }
}