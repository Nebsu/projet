<?php
// fonction permettant de récupérer un lien youtube entré par l'utilisateur
// dans le contenu de sa publication, pour permettre d'afficher directement
// le YouTube Video Player sur notre site (comme sur discord)
// Le lien doit être obligatoirement à la fin du message
// Le lien doit être de la forme : https://www.youtube.com/watch?v=(id video)
function char_at($str, $pos)
{return (string) $str{$pos};}

function youtube_link($text) {
	$res = " ";
	for ($i=0; $i<strlen($text); $i++) { 
		$c = char_at($text, $i);
		if ($c=="h") {
			$cut = substr($text, $i); 
			if (substr($cut, 0, 24)=="https://www.youtube.com/") {
				$j = 0;
				for ($j; $j<strlen($cut); $j++) {
					if (char_at($cut, $j+1)=="w" && char_at($cut, $j+2)=="a") break; 
				}
				$k = $j+8;
				for ($k; $k<strlen($cut); $k++) {}
				$s = substr($cut, $j+9, $k);
				$res = substr($cut, 0, $j)."/embed/".$s;
				break;
			}
		}
	}
	return $res;
}
?>