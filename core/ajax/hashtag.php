<?php
include '../int.php';
if(isset($_POST['hashtag'])){
	$hashtag=$getFromU->checkInput($_POST['hashtag']);
	if(substr($hashtag,0,1)==='#'){
		$trend=str_replace('#','', $hashtag);
		$trends=$getFromT->getTrendByHash($trend);
		foreach ($trends as $hashtag) {
		echo '<li><a href="#"><span class="getValue">'.$hashtag'</span></a></li>';

		}
	}
}

?>