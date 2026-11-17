<?php

namespace iutnc\deefy\audio\tracks;

require_once 'AudioTrack.php';

class AlbumTrack extends AudioTrack{
    protected string $album;
    protected int $numero_piste;

    public function __construct(string $titre,
                                string $path,
                                string $album,
                                int $numero_piste){
        
        parent::__construct($titre, $path);
        $this->album = $album;
        $this->numero_piste = $numero_piste;
    }

}