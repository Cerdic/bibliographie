<?php
/**
 * Utilisations de pipelines par Bibliographie
 *
 * @plugin     Bibliographie
 * @copyright  2013
 * @author     Cédric
 * @licence    GNU/GPL
 * @package    SPIP\Biblio\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) return;
	


/**
 * Ajout de contenu sur certains objets,
 * notamment des formulaires de liaisons entre objets
 *
 * @pipeline afficher_complement_objet
 * @param  array $flux Données du pipeline
 * @return array       Données du pipeline
 */
function biblio_afficher_complement_objet($flux) {
	// ouvrages sur les rubriques, articles
	$texte = "";
	if (in_array($flux['args']['type'], array('rubrique', 'article'))) {
		$texte .= recuperer_fond('prive/objets/editer/liens', array(
			'table_source' => 'ouvrages',
			'objet' => $flux['args']['type'],
			'id_objet' => $flux['args']['id']
		));
	}

	if ($texte) {
		#if ($p=strpos($flux['data'],"<!--affiche_milieu-->"))
		#	$flux['data'] = substr_replace($flux['data'],$texte,$p,0);
		#else
			$flux['data'] .= "<div class='nettoyeur'></div>".$texte;
	}

	return $flux;
}


/**
 * Optimiser la base de données en supprimant les liens orphelins
 * de l'objet vers quelqu'un et de quelqu'un vers l'objet.
 *
 * @pipeline optimiser_base_disparus
 * @param  array $flux Données du pipeline
 * @return array       Données du pipeline
 */
function biblio_optimiser_base_disparus($flux){
	include_spip('action/editer_liens');
	$flux['data'] += objet_optimiser_liens(array('ouvrage'=>'*'),'*');
	return $flux;
}

?>