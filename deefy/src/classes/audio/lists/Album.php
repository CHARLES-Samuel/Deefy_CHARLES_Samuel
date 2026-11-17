<?php

namespace iutnc\deefy\audio\lists;

require_once 'AudioList.php';

class Album extends AudioList{

    protected string $nom_artiste_album;
    protected string $date_sortie_album;    

    public function __construct(string $nom_liste,array $tab_pistes){
        parent::__construct($nom_liste, $tab_pistes);
    }

    public function setNomArtisteAlbum(string $nom_artiste_album){
        if($nom_artiste_album != ""){
            $this->nom_artiste_album = $nom_artiste_album;
        }
    }

    public function setDateAlbum(string $date_album){
        if($date_album != ""){
            $this->date_sortie_album = $date_album;
        }
    }
}