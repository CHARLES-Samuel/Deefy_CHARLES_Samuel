<?php

namespace iutnc\deefy\audio\lists;
use iutnc\deefy\exception\InvalidPropertyNameException;
use Iterator;

class AudioList implements Iterator{

    protected int $id = 0;
    protected string $nom_liste;
    protected int $nb_pistes;
    protected int $duree_total;
    protected array $tab_pistes;
    
    protected int $position;

    public function __construct(string $nom_liste,array $tab_pistes = []){
        $this->nom_liste = $nom_liste;
        $this->tab_pistes = $tab_pistes;
        $this->nb_pistes = count($tab_pistes);
        $this->duree_total = $this->sommeDesDuree($tab_pistes);
        $this->position = 0;
    }

    private function sommeDesDuree(array $tab_pistes) : int{
        $res = 0;

        foreach($tab_pistes as $track){
            $res += $track->duree_secondes;
        }

        return $res;
    }

    public function __get(string $at) : mixed{
        if(property_exists($this,$at)){
            return $this->$at;
        }
        throw new InvalidPropertyNameException("invalid property : " . $at);
    }

    public function setID(int $newID) :void{
        if ($newID > 0)
            $this->id = $newID;
    }

    public function rewind(): void {
        $this->position = 0;
    }

    public function current() : mixed{
        return $this->tab_pistes[$this->position];
    }

    public function key() : mixed{
        return $this->position;
    }

    public function next(): void {
        ++$this->position;
    }

    public function valid(): bool {
        return isset($this->tab_pistes[$this->position]);
    }
}