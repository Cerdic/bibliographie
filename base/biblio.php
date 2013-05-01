<?php
/**
 * Déclarations relatives à la base de données
 *
 * @plugin     Bibliographie
 * @copyright  2013
 * @author     Cédric
 * @licence    GNU/GPL
 * @package    SPIP\Biblio\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


/**
 * Déclaration des alias de tables et filtres automatiques de champs
 *
 * @pipeline declarer_tables_interfaces
 * @param array $interfaces
 *     Déclarations d'interface pour le compilateur
 * @return array
 *     Déclarations d'interface pour le compilateur
 */
function biblio_declarer_tables_interfaces($interfaces) {

	$interfaces['table_des_tables']['ouvrages'] = 'ouvrages';

	return $interfaces;
}


/**
 * Déclaration des objets éditoriaux
 *
 * @pipeline declarer_tables_objets_sql
 * @param array $tables
 *     Description des tables
 * @return array
 *     Description complétée des tables
 */
function biblio_declarer_tables_objets_sql($tables) {

	$tables['spip_ouvrages'] = array(
		'type' => 'ouvrage',
		'principale' => "oui",
		'field'=> array(
			"id_ouvrage"         => "bigint(21) NOT NULL",
			"titre"              => "text NOT NULL DEFAULT ''",
			"soustitre"          => "text NOT NULL DEFAULT ''",
			"auteur"             => "text NOT NULL DEFAULT ''",
			"ref"                => "varchar(255) NOT NULL DEFAULT ''",
			"url"                => "varchar(255) NOT NULL DEFAULT ''",
			"descriptif"         => "text NOT NULL DEFAULT ''",
			"annee"              => "int(11) NOT NULL DEFAULT 0",
			"editeur"            => "text NOT NULL DEFAULT ''",
			"date_modif"         => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'", 
			"statut"             => "varchar(20)  DEFAULT '0' NOT NULL", 
			"maj"                => "TIMESTAMP"
		),
		'key' => array(
			"PRIMARY KEY"        => "id_ouvrage",
			"KEY statut"         => "statut", 
		),
		'titre' => "titre AS titre, '' AS lang",
		'date' => "date_modif",
		'champs_editables'  => array('titre', 'soustitre', 'auteur', 'ref', 'url', 'descriptif', 'annee', 'editeur'),
		'champs_versionnes' => array('titre', 'soustitre', 'auteur', 'ref', 'url', 'descriptif', 'annee', 'editeur'),
		'rechercher_champs' => array("titre" => 8, "soustitre" => 4, "auteur" => 4, "ref" => 1, "descriptif" => 1, "editeur" => 2),
		'tables_jointures'  => array('spip_ouvrages_liens'),
		'statut_textes_instituer' => array(
			'prop'     => 'texte_statut_propose_evaluation',
			'publie'   => 'texte_statut_publie',
			'refuse'   => 'texte_statut_refuse',
			'poubelle' => 'texte_statut_poubelle',
		),
		'statut'=> array(
			array(
				'champ'     => 'statut',
				'publie'    => 'publie',
				'previsu'   => 'publie,prop',
				'exception' => array('statut','tout')
			)
		),
		'texte_changer_statut' => 'ouvrage:texte_changer_statut_ouvrage', 
		

	);

	return $tables;
}


/**
 * Déclaration des tables secondaires (liaisons)
 *
 * @pipeline declarer_tables_auxiliaires
 * @param array $tables
 *     Description des tables
 * @return array
 *     Description complétée des tables
 */
function biblio_declarer_tables_auxiliaires($tables) {

	$tables['spip_ouvrages_liens'] = array(
		'field' => array(
			"id_ouvrage"         => "bigint(21) DEFAULT '0' NOT NULL",
			"id_objet"           => "bigint(21) DEFAULT '0' NOT NULL",
			"objet"              => "VARCHAR(25) DEFAULT '' NOT NULL",
			"vu"                 => "VARCHAR(6) DEFAULT 'non' NOT NULL"
		),
		'key' => array(
			"PRIMARY KEY"        => "id_ouvrage,id_objet,objet",
			"KEY id_ouvrage"     => "id_ouvrage"
		)
	);

	return $tables;
}


?>