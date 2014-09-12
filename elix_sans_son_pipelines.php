<?php
/**
 * Fichier de déclaration des pipelines du plugin
 * 
 * @author kent1 (http://www.kent1.info - kent1@arscenic.info)
 * @license GPL
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * Insertion dans le pipeline taches_generales_cron
 *
 * Vérifie la présence à intervalle régulier de fichiers à convertir
 * dans la file d'attente et lance le premier
 * 
 * On exécute la tache toutes les 2 minutes
 *
 * @param array $taches_generales Un array des tâches du cron de SPIP
 * @return L'array des taches complété
 */
function elix_sans_son_taches_generales_cron($taches_generales){
	$taches_generales['elix_sans_son'] = 60;
	return $taches_generales;
}

?>