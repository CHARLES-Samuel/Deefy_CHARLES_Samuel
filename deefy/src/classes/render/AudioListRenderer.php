<?php

namespace iutnc\deefy\render;
use iutnc\deefy\audio\lists\AudioList;

require_once 'Renderer.php';

class AudioListRenderer implements Renderer {

    private AudioList $audioList;
    public function __construct(AudioList $audioList) {
        $this->audioList = $audioList;
    }

    public function render(int $selector = Renderer::COMPACT) : string {
        $res = "<p>" . htmlspecialchars($this->audioList->nom_liste, ENT_QUOTES, 'UTF-8', false) . " :</p>\n";

        foreach($this->audioList as $audio){
            $renderer = RendererFactory::GetRenderer($audio);
            $res .= $renderer->compact() . "\n<br>";
        }
        $res .= "<p>Nombre de pistes : " . $this->audioList->nb_pistes . "<br>\n";
        $res .= "Duree Total : " . $this->audioList->duree_total . "</p>";
        return $res;
    }
}