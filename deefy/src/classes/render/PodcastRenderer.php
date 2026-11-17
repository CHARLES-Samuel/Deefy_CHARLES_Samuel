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
        $res = "<ul>";
        $res = $res . "<li> Titre : " . htmlspecialchars($this->podcastTrack->titre, ENT_QUOTES, 'UTF-8', false) . "</li>";
        $res = $res . "<li> Artiste : " . htmlspecialchars($this->podcastTrack->artiste, ENT_QUOTES, 'UTF-8', false) . "</li>";
        $res = $res . "</ul>";
        $res = $res . "<audio controls src=\"" . htmlspecialchars($this->podcastTrack->path, ENT_QUOTES, 'UTF-8', false) . "\"></audio>";
        return $res;
    }

    public function long() : string {
        $res = "<ul>";
        $res .= "<li> Titre : " . htmlspecialchars($this->podcastTrack->titre, ENT_QUOTES, 'UTF-8', false) . "</li>";
        $res .= "<li> Artiste : " . htmlspecialchars($this->podcastTrack->artiste, ENT_QUOTES, 'UTF-8', false) . "</li>";
        $res .= "<li> Durée : " . $this->podcastTrack->duree_secondes . "s </li>";
        $res .= "<li> Genre : " . $this->podcastTrack->genre . "</li>";
        $res .= "</ul>";
        $res .= "<audio controls src=\"" . htmlspecialchars($this->podcastTrack->path, ENT_QUOTES, 'UTF-8', false) . "\"></audio>";
        return $res;
    }
}