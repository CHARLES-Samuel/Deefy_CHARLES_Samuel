<?php

namespace iutnc\deefy\audio\tracks;

use iutnc\deefy\exception\InvalidPropertyNameException;
use iutnc\deefy\exception\InvalidPropertyValueException;

class AudioTrack{

    public const BLUES = 0;
    public const FUNK = 5;
    public const HIPHOP = 7;
    public const JAZZ = 8;
    public const ROCK = 17;
    public const TECHNO = 18;
    public const DEATH_METAL = 22;

    protected ?int $id;
    protected string $artiste = "Artiste inconnu";
    protected string $titre;
    protected ?string $date;
    protected ?int $genre;
    protected int $duree_secondes = 10;
    protected string $nom_fichier_audio = "Inconnu";
    protected string $path = "Inconnu";

    public function __construct(string $titre,
                                string $path){
        $this->titre = $titre;
        $this->path = $path;
    }

    public static function GetGenreAsString(int $genre){
        $tabGenres = [
            0 => 'blues',
            5 => 'funk',
            7 => 'hip-hop',
            8 => 'jazz',
            17 => 'rock',
            18 => 'techno',
            22 => 'death metal',
        ];

        return isset($tabGenres[$genre]) ? $tabGenres[$genre] : 'Genre inconnu';
    }

    public function __toString() : string{
        $array = get_object_vars($this);
        return json_encode($array);
    }

    public function __get(string $at) : mixed{
        if(property_exists($this,$at)){
            return $this->$at;
        }
        throw new InvalidPropertyNameException("invalid property : " . $at);
    }

    public function setArtiste(string $nameArtiste){
        if ($nameArtiste != null) {
            $this->artiste = $nameArtiste;
        }
    }    

    public function setDate(string $date){
        if ($date != null) {
            $this->date = $date;
        }
    }

    public function setGenre (int $genre){
        if ($genre != null) {
            $this->genre = $genre;
        }
    }

    public function setduree_secondes (int $duree){
        if ($duree > 0) {
            $this->duree_secondes = $duree;
        } else {
            throw new InvalidPropertyValueException("La nouvelle duree doit etre superieur a 0 " . $duree);
        }
    }

    public function setNomFichier(string $nomFichier){
        if ($nomFichier != null) {
            $this->nom_fichier_audio = $nomFichier;
        }
    }

    public function setID(int $newID) :void{
        if ($newID > 0)
            $this->id = $newID;
    }
}