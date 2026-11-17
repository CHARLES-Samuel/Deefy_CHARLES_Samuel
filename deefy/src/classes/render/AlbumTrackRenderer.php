<?php

namespace iutnc\deefy\render;
use iutnc\deefy\audio\tracks\AlbumTrack;

require_once 'AudioTrackRenderer.php';

class AlbumTrackRenderer extends AudioTrackRenderer{
    public AlbumTrack $albumTrack;

    public function __construct(AlbumTrack $albumTrack){
        $this->albumTrack = $albumTrack;
    }

    public function compact() : string {
        $res = "<ul>";
        $res = $res . "<li> Titre : " . htmlspecialchars($this->albumTrack->titre, ENT_QUOTES, 'UTF-8', false) . "</li>";
        $res = $res . "<li> Artiste : " . htmlspecialchars($this->albumTrack->artiste, ENT_QUOTES, 'UTF-8', false) . "</li>";
        $res = $res . "<li> Album : " . htmlspecialchars($this->albumTrack->album, ENT_QUOTES, 'UTF-8', false) . "</li>";
        $res = $res . "</ul>";
        $res = $res . "<audio controls src=\"" . htmlspecialchars($this->albumTrack->path, ENT_QUOTES, 'UTF-8', false) . "\"></audio>";
        return $res;
    }

   public function long() : string {
        $res = "<ul>";
        $res .= "<li> Titre : " . htmlspecialchars($this->albumTrack->titre, ENT_QUOTES, 'UTF-8', false) . "</li>";
        $res .= "<li> Artiste : " . htmlspecialchars($this->albumTrack->artiste, ENT_QUOTES, 'UTF-8', false) . "</li>";
        $res .= "<li> Album : " . htmlspecialchars($this->albumTrack->album, ENT_QUOTES, 'UTF-8', false) . "</li>";
        $res .= "<li> Numéro : " . $this->albumTrack->numero_piste . "</li>";
        $res .= "<li> Durée : " . $this->albumTrack->duree_secondes . "s </li>";
        $res .= "<li> Genre : " . $this->albumTrack->genre . "</li>";
        $res .= "</ul>";
        $res .= "<audio controls src=\"" . htmlspecialchars($this->albumTrack->path, ENT_QUOTES, 'UTF-8', false) . "\"></audio>";
        return $res;
    }
}