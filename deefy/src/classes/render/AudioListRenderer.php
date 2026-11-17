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
        $nom = htmlspecialchars($this->audioList->nom_liste, ENT_QUOTES, 'UTF-8', false);
        $res = "<div class=\"d-flex justify-content-between align-items-center border-bottom border-secondary pb-3 mb-4\">";
        $res .= "<h2 class=\"h3 mb-0\">$nom</h2>";
        $res .= "<div class=\"d-flex gap-2\">";
        $res .= "<span class=\"badge metal-badge\">Pistes : " . $this->audioList->nb_pistes . "</span>";
        $res .= "<span class=\"badge metal-badge\">Durée : " . $this->audioList->duree_total . "s</span>";
        $res .= "</div></div>";

        $res .= "<div class=\"d-flex flex-column gap-3\">";
        foreach($this->audioList as $audio){
            $renderer = RendererFactory::GetRenderer($audio);
            $res .= $renderer->compact();
        }
        $res .= "</div>";
        return $res;
    }
}