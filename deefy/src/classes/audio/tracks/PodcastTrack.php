<?php

namespace iutnc\deefy\audio\tracks;

require_once 'AudioTrack.php';

class PodcastTrack extends AudioTrack {
    
    public function __construct(string $titre,
                                string $path) {
        parent::__construct($titre, $path);
    }
}