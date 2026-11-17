<?php

namespace iutnc\deefy\render;
use iutnc\deefy\audio\tracks\PodcastTrack;

require_once 'AudioTrackRenderer.php';

class PodcastRenderer extends AudioTrackRenderer {

    public PodcastTrack $podcastTrack;
    
    public function __construct(PodcastTrack $podcastTrack){
        $this->podcastTrack = $podcastTrack;
    }

    public function compact() : string {
        $titre = htmlspecialchars($this->podcastTrack->titre, ENT_QUOTES, 'UTF-8', false);
        $artiste = htmlspecialchars($this->podcastTrack->artiste, ENT_QUOTES, 'UTF-8', false);
        $path = htmlspecialchars($this->podcastTrack->path, ENT_QUOTES, 'UTF-8', false);

        $res = "<div class=\"metal-card p-3\">";
        $res .= "<div class=\"d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-2\">";
        $res .= "<span class=\"track-title\">$titre</span>";
        $res .= "<span class=\"track-meta\">$artiste // PODCAST</span>";
        $res .= "</div>";
        $res .= "<audio controls src=\"$path\"></audio>";
        $res .= "</div>";
        return $res;
    }

    public function long() : string {
        $titre = htmlspecialchars($this->podcastTrack->titre, ENT_QUOTES, 'UTF-8', false);
        $artiste = htmlspecialchars($this->podcastTrack->artiste, ENT_QUOTES, 'UTF-8', false);
        $path = htmlspecialchars($this->podcastTrack->path, ENT_QUOTES, 'UTF-8', false);

        $res = "<div class=\"metal-card p-3\">";
        $res .= "<div class=\"mb-2\"><span class=\"track-title\">$titre</span></div>";
        $res .= "<ul class=\"list-unstyled track-meta mb-2\">";
        $res .= "<li>Auteur : $artiste</li>";
        $res .= "<li>Durée : " . $this->podcastTrack->duree_secondes . "s</li>";
        $res .= "</ul>";
        $res .= "<audio controls src=\"$path\"></audio>";
        $res .= "</div>";
        return $res;
    }
}