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
        $titre = htmlspecialchars($this->albumTrack->titre, ENT_QUOTES, 'UTF-8', false);
        $artiste = htmlspecialchars($this->albumTrack->artiste, ENT_QUOTES, 'UTF-8', false);
        $album = htmlspecialchars($this->albumTrack->album, ENT_QUOTES, 'UTF-8', false);
        $path = htmlspecialchars($this->albumTrack->path, ENT_QUOTES, 'UTF-8', false);

        $res = "<div class=\"metal-card p-3\">";
        $res .= "<div class=\"d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-2\">";
        $res .= "<span class=\"track-title\">$titre</span>";
        $res .= "<span class=\"track-meta\">$artiste // $album</span>";
        $res .= "</div>";
        $res .= "<audio controls src=\"$path\"></audio>";
        $res .= "</div>";
        return $res;
    }

   public function long() : string {
        $titre = htmlspecialchars($this->albumTrack->titre, ENT_QUOTES, 'UTF-8', false);
        $artiste = htmlspecialchars($this->albumTrack->artiste, ENT_QUOTES, 'UTF-8', false);
        $album = htmlspecialchars($this->albumTrack->album, ENT_QUOTES, 'UTF-8', false);
        $path = htmlspecialchars($this->albumTrack->path, ENT_QUOTES, 'UTF-8', false);

        $res = "<div class=\"metal-card p-3\">";
        $res .= "<div class=\"mb-2\"><span class=\"track-title\">$titre</span></div>";
        $res .= "<ul class=\"list-unstyled track-meta mb-2\">";
        $res .= "<li>Artiste : $artiste</li>";
        $res .= "<li>Album : $album (#" . $this->albumTrack->numero_piste . ")</li>";
        $res .= "<li>Durée : " . $this->albumTrack->duree_secondes . "s</li>";
        $res .= "</ul>";
        $res .= "<audio controls src=\"$path\"></audio>";
        $res .= "</div>";
        return $res;
    }
}