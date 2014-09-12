<?php
/**
 * Fichier des fonctions utilisées en CRON
 * 
 * @author kent1 (http://www.kent1.info - kent1@arscenic.info)
 * @license GPL
 */

/**
 * Fonction appelée par le génie de SPIP à intervalle régulier
 * On lance une conversion
 * 
 * @param object $time
 * @return int
 */
function genie_elix_sans_son($time){
	$id_document = sql_getfetsel('documents.id_document','spip_documents AS `documents` INNER JOIN spip_documents_liens AS L3 ON ( L3.id_document = documents.id_document ) INNER JOIN spip_articles AS L4 ON ( L4.id_article = L3.id_objet AND L3.objet="article")',"(documents.statut = 'publie') AND (documents.taille > 0 OR documents.distant='oui') AND (L4.id_secteur = 94715) AND (documents.mode = 'document') AND (documents.media = 'video') AND (documents.hasaudio = 'oui')",'','','0,1');
	$traiter = charger_fonction('elix_sansson_reencode','action');
	$traiter($id_document);
	return 1;
}

?>