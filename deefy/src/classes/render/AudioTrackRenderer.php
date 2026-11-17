<?php

namespace iutnc\deefy\render;

require_once 'Renderer.php';

abstract class AudioTrackRenderer implements Renderer{

    public function render(int $selector = Renderer::COMPACT) : string {
        switch($selector) {
            case Renderer::COMPACT:
                return $this->compact();
            case Renderer::LONG:
                return $this->long();
            default :
                return $this->compact();
        }
    }

    abstract public function compact();
    abstract public function long();
}