<?php

namespace App\Schulze;

use DB;
use PDO;
use App\Image;
use App\Campagne;
use App\Vote;

class Calcul {
    private $campagne;          // Campagne
    private $C;                 // Nombre de candidats
    private $V;                 // Nombre réel de votants
    private $U;                 // Part de votes d'utilisateurs

    private $images;            // Liste des images
    private $preferences;       // Tableau des préférences
    private $force;             // Tableau des chemins de force

    // Initialisation des variables par le constructeur Calcul
    public function __construct($id_campagne) {
        $this->campagne = Campagne::find($id_campagne);

        // Si la campagne existe, on continue...
        if (!is_null($this->campagne)) {
            $this->C = $this->campagne->getNombreImages();
            $this->U = $this->campagne->choix_popularite;

            // On remplit le tableau des identifiants d'images
            $this->images = array();
            $this->campagne->retrieveImages()->each(function($item, $key) {
                array_push($this->images, $item->id_image);
            });

            // On répartit les préférences des images entre elles
            $this->nombreVotants();
            $this->repartirPreferences();
        }
    }

    // Répartition des préférences des utilisateurs et des jurés
    protected function repartirPreferences() {
        // DB::setFetchMode(PDO::FETCH_ASSOC);

        for ($i = 0; $i < $this->C; $i++) {

            // On initialise un tableau qui contiendra les préférences pour une image i
            $candidat = array();

            for ($j = 0; $j < $this->C; $j++) {
                if ($i != $j) {

                    /*  EXPLICATIONS SUR LES PRÉFÉRENCES : CALCUL DE $preferences
                     *  On doit combiner les votes des jurés et les votes des utilisateurs avec répartition
                     *      -> Les utilisateurs contribuent à hauteur de [0%;50%] des votes
                     *      -> Les jurés complètent pour arriver à 100%
                     *
                     *  Pour une participation d'utilisateurs de 20%, on peut donner l'exemple suivant :
                     *      -> Quinze jurés sur vingt préfèrent l'image A à l'image B        / $s pour (A,B) ci-dessous renverra 15
                     *      -> Dix utilisateurs aiment l'image A, trente aiment l'image B    / L'image B est en première position
                     *
                     *      -> On modélise les utilisateurs comme des jurés d'importance 20% (suivant l'avis du juré fictif)
                     *      -> Le classement du juré fictif est celui du nombre d'appréciations des images
                     *
                     *       20j |  xj
                     *      -----------
                     *       80% | 20%
                     *
                     *      -> 80% du vote sont donc constitués de l'avis de vingt jurés
                     *      -> Les 20% restants sont l'avis de x faux jurés qui suivent l'avis du juré fictif pour garder les proportions
                     *
                     *      -> Dans notre exemple, x = 5 et ces cinq faux jurés comptent pour zéro car ils ne préfèrent pas strictement A à B
                     *      -> Le nombre de jurés qui préfèrent A à B est donc de 15.
                     */

                    // On calcule le nombre de jurés réels qui préfèrent strictement l'image $i à l'image $j
                    $s = DB::select('SELECT COUNT(DISTINCT v.id_utilisateur) AS result
                                     FROM vote v
                                     WHERE (v.id_campagne LIKE :idc) AND
	                                       (v.id_image LIKE :idi) AND
	                                       (v.position < IFNULL((SELECT u.position
					                                             FROM vote u
					                                             WHERE (u.id_campagne LIKE :idd) AND
						                                               (u.id_image LIKE :idj) AND
						                                               (u.id_utilisateur LIKE v.id_utilisateur)), :max))',
                            ['idc' => $this->campagne->id_campagne,
                             'idd' => $this->campagne->id_campagne,
                             'idi' => $this->images[$i],
                             'idj' => $this->images[$j],
                             'max' => 99999]);

                    // On renvoie la différence de « J'aime » entre l'image $i à l'image $j
                    $t = DB::select('SELECT (SELECT COUNT(*)
                                     FROM apprecie a
                                     WHERE (a.id_image = :idi)) -

                                     (SELECT COUNT(*)
                                      FROM apprecie b
                                      WHERE (b.id_image = :idj)) AS result',
                            ['idi' => $this->images[$i],
                             'idj' => $this->images[$j]]);

                    // On interprète cette différence : 1 si $i > $j, 0 sinon
                    $avis_utilisateurs = 0;
                    if ($t[0]->result > 0)
                        $avis_utilisateurs = 1;


                    $pourcentage_user = $this->U;
                    $pourcentage_jure = 100 - $this->U;

                    // On calcule le nombre de votes fictifs que représente la part des utilisateurs
                    $nb_votes = (($this->V * $pourcentage_user) / $pourcentage_jure) * $avis_utilisateurs;

                    // On en déduit le nombre de votes final, égal aux votes des jurés plus ceux des utilisateurs
                    $nb_votes_final = $s[0]->result + $nb_votes;
                    $candidat[$this->images[$j]] = $nb_votes_final;
                }
            }

            // On affecte le tableau
            $this->preferences[$this->images[$i]] = $candidat;
        }

        DB::setFetchMode(PDO::FETCH_CLASS);
    }

    // Calcul du vainqueur
    public function gagnants() {
        // Initialisation du tableau de force
        $this->force = array();
        foreach ($this->images as $code) {
            $this->force[$code] = array();
        }

        // Initialisation des chemins de force
        for ($i = 0; $i < $this->C; $i++) {
            for ($j = 0; $j < $this->C; $j++) {
                if ($i != $j) {
                    if ($this->preferences[$this->images[$i]][$this->images[$j]]
                            > $this->preferences[$this->images[$j]][$this->images[$i]]) {
                        $this->force[$this->images[$i]][$this->images[$j]] = $this->preferences[$this->images[$i]][$this->images[$j]];
                    } else {
                        $this->force[$this->images[$i]][$this->images[$j]] = 0;
                    }
                }
            }
        }

        // Déroulement de Floyd-Warshall
        for ($i = 0; $i < $this->C; $i++) {
            for ($j = 0; $j < $this->C; $j++) {

                if ($i != $j) {
                    for ($k = 0; $k < $this->C; $k++) {

                        if (($i != $k) && ($j != $k)) {
                            $this->force[$this->images[$j]][$this->images[$k]]
                                = max($this->force[$this->images[$j]][$this->images[$k]],
                                      min($this->force[$this->images[$j]][$this->images[$i]],
                                          $this->force[$this->images[$i]][$this->images[$k]]));
                        }
                    }
                }
            }
        }

        // Initialisation du tableau des gagnants
        $gagnants = array();
        foreach ($this->images as $code) {
            $gagnants[$code] = true;
        }

        // Duels de Condorcet pour avoir un gagnant potentiel
        for ($i = 0; $i < $this->C; $i++) {
            for ($j = 0; $j < $this->C; $j++) {
                if ($i != $j) {
                    if ($this->force[$this->images[$j]][$this->images[$i]] > $this->force[$this->images[$i]][$this->images[$j]]) {
                        $gagnants[$this->images[$i]] = false;
                    }
                }
            }
        }

        return $gagnants;
    }

    // Nombre de votants effectifs de la campagne
    protected function nombreVotants() {
        $this->V = DB::table('vote')->where('id_campagne', $this->campagne->id_campagne, false)
                                    ->distinct()->count(['id_utilisateur']);
    }
}