<?php
/**
 * Gestion du formulaire de d'édition de ouvrage
 *
 * @plugin     Bibliographie
 * @copyright  2013
 * @author     Cédric
 * @licence    GNU/GPL
 * @package    SPIP\Biblio\Formulaires
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/actions');
include_spip('inc/editer');

/**
 * Identifier le formulaire en faisant abstraction des paramètres qui ne représentent pas l'objet edité
 *
 * @param int|string $id_ouvrage
 *     Identifiant du ouvrage. 'new' pour un nouveau ouvrage.
 * @param string $retour
 *     URL de redirection après le traitement
 * @param string $associer_objet
 *     Éventuel `objet|x` indiquant de lier le ouvrage créé à cet objet,
 *     tel que `article|3`
 * @param int $lier_trad
 *     Identifiant éventuel d'un ouvrage source d'une traduction
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du ouvrage, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return string
 *     Hash du formulaire
 */
function formulaires_editer_ouvrage_identifier_dist($id_ouvrage='new', $retour='', $associer_objet='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
	return serialize(array(intval($id_ouvrage), $associer_objet));
}

/**
 * Chargement du formulaire d'édition de ouvrage
 *
 * Déclarer les champs postés et y intégrer les valeurs par défaut
 *
 * @uses formulaires_editer_objet_charger()
 *
 * @param int|string $id_ouvrage
 *     Identifiant du ouvrage. 'new' pour un nouveau ouvrage.
 * @param string $retour
 *     URL de redirection après le traitement
 * @param string $associer_objet
 *     Éventuel `objet|x` indiquant de lier le ouvrage créé à cet objet,
 *     tel que `article|3`
 * @param int $lier_trad
 *     Identifiant éventuel d'un ouvrage source d'une traduction
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du ouvrage, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Environnement du formulaire
 */
function formulaires_editer_ouvrage_charger_dist($id_ouvrage='new', $retour='', $associer_objet='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
	$valeurs = formulaires_editer_objet_charger('ouvrage',$id_ouvrage,'',$lier_trad,$retour,$config_fonc,$row,$hidden);
	return $valeurs;
}

/**
 * Vérifications du formulaire d'édition de ouvrage
 *
 * Vérifier les champs postés et signaler d'éventuelles erreurs
 *
 * @uses formulaires_editer_objet_verifier()
 *
 * @param int|string $id_ouvrage
 *     Identifiant du ouvrage. 'new' pour un nouveau ouvrage.
 * @param string $retour
 *     URL de redirection après le traitement
 * @param string $associer_objet
 *     Éventuel `objet|x` indiquant de lier le ouvrage créé à cet objet,
 *     tel que `article|3`
 * @param int $lier_trad
 *     Identifiant éventuel d'un ouvrage source d'une traduction
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du ouvrage, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Tableau des erreurs
 */
function formulaires_editer_ouvrage_verifier_dist($id_ouvrage='new', $retour='', $associer_objet='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
	return formulaires_editer_objet_verifier('ouvrage',$id_ouvrage, array('titre'));
}

/**
 * Traitement du formulaire d'édition de ouvrage
 *
 * Traiter les champs postés
 *
 * @uses formulaires_editer_objet_traiter()
 *
 * @param int|string $id_ouvrage
 *     Identifiant du ouvrage. 'new' pour un nouveau ouvrage.
 * @param string $retour
 *     URL de redirection après le traitement
 * @param string $associer_objet
 *     Éventuel `objet|x` indiquant de lier le ouvrage créé à cet objet,
 *     tel que `article|3`
 * @param int $lier_trad
 *     Identifiant éventuel d'un ouvrage source d'une traduction
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du ouvrage, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Retours des traitements
 */
function formulaires_editer_ouvrage_traiter_dist($id_ouvrage='new', $retour='', $associer_objet='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
	$res = formulaires_editer_objet_traiter('ouvrage',$id_ouvrage,'',$lier_trad,$retour,$config_fonc,$row,$hidden);
 
	// Un lien a prendre en compte ?
	if ($associer_objet AND $id_ouvrage = $res['id_ouvrage']) {
		list($objet, $id_objet) = explode('|', $associer_objet);

		if ($objet AND $id_objet AND autoriser('modifier', $objet, $id_objet)) {
			include_spip('action/editer_liens');
			objet_associer(array('ouvrage' => $id_ouvrage), array($objet => $id_objet));
			if (isset($res['redirect'])) {
				$res['redirect'] = parametre_url ($res['redirect'], "id_lien_ajoute", $id_ouvrage, '&');
			}
		}
	}
	return $res;

}


?>