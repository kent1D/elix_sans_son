<?php
/**
 * Fonction de réencodage de videos sans piste son
 * 
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_elix_sansson_reencode_dist(){
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();

	$ps_ffmpeg = exec('ps -C ffmpeg',$retour,$retour_int);
	spip_log($ps_ffmpeg,'test.'._LOG_ERREUR);

	if(($retour_int == 1) && (count($retour) >= 3)){
		spip_log('Il y a a apparemment trop de processus de ffmpeg en cours, on attend donc','spipmotion');
		$ret['success'] = true;
		$ret['statut'] = 'non';
		spip_log($ret,'test.'._LOG_ERREUR);
		return $ret;
	}
	
	include_spip('inc/documents');
	$source = sql_fetsel('*','spip_documents','id_document='.intval($arg));
	if(isset($source['fichier'])){
		$chemin = get_spip_doc($source['fichier']);
		$dest = _DIR_TMP.basename($source['fichier']);
		$commande = 'ffmpeg -i '.escapeshellarg($chemin).' -an -vcodec copy '.escapeshellarg($dest);
		spip_log($commande,'test.'._LOG_ERREUR);
		$encodage = exec($commande,$retour,$retour_int);
		if(file_exists($dest) && filesize($dest) > 0){
			@rename($chemin,"$chemin--.old");
			spip_log('on a un fichier '.$dest,'test.'._LOG_ERREUR);
			$id_article = sql_getfetsel('id_objet','spip_documents_liens','id_document='.intval($arg).' AND objet="article"');
			$ajouter_doc = charger_fonction('ajouter_documents','action');
			$objet = 'article';
			$id_objet = $id_article;
			$mode = 'document';
			$files = array();
			$filename = basename($dest);
			$files[0]['tmp_name'] = $dest;
			$files[0]['name'] = $filename;
			$id_document_new = $ajouter_doc($arg,$files, $objet, $id_objet, $mode);
			spip_log($id_document_new,'test.'._LOG_ERREUR);
			if (intval(reset($id_document_new)) > 0){
				// retablir le fichier !
				if ($chemin)
					@rename("$chemin--.old",$chemin);
			}
			else
				// supprimer vraiment le fichier initial
				spip_unlink("$chemin--.old");
		}
	}
}

?>