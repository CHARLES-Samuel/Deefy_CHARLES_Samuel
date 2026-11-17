<?php

namespace iutnc\deefy\audio\lists;
use iutnc\deefy\audio\tracks\AudioTrack;

require_once 'AudioList.php';

class Playlists extends AudioList {

    public function ajoutPiste(AudioTrack $track) {
        if ($track != null) {
            $this->tab_pistes[] = $track;
            $this->nb_pistes++;
            $this->duree_total += $track->duree_secondes;
        }
    }

    public function supprimerPiste(int $indice_piste) {
        unset($this->tab_pistes[$indice_piste]);
    }

    public function ajouterListePiste(array $liste_piste){
        if ($liste_piste != null){
            $this->tab_pistes = array_merge($this->tab_pistes, $liste_piste); // merge les deux tab     
            $this->tab_pistes = array_unique($this->tab_pistes); // supprime les doublons
            $this->tab_pistes = array_values($this->tab_pistes); // reinitialise les cles 
        }
    }
}