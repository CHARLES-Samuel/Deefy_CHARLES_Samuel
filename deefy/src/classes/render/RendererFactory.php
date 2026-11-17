<?php

namespace iutnc\deefy\render;

use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;

class RendererFactory{

    public static function GetRenderer(AudioTrack $track){
        if ($track instanceof AlbumTrack)
            return new AlbumTrackRenderer($track);
        if ($track instanceof PodcastTrack)
            return new PodcastRenderer($track);
    }
}