<?php

	// fonction pour détecter l'extension d'un fichier importé par l'utilisateur
	function extension($name) {
		if (file_exists("thumbs/".$name.".gif")) $ex = ".gif";
		else if (file_exists("thumbs/".$name.".jpg")) $ex = ".jpg";
		else if (file_exists("thumbs/".$name.".png")) $ex = ".png";
		else $ex = " ";
		return $ex;
	}

	function image_exist($name) {
		if (extension($name)==".gif" || extension($name)==".jpg" || extension($name)==".png") return true;
		else return false;
	}

?>