<?php
class Tweet extends User {

function __construct($pdo){
	$this->pdo=$pdo;
}

public function tweets($user_id){
	$stmt=$this->pdo->prepare("SELECT * FROM `tweets`,`users` WHERE `user_id`=`tweetBy`");
	$stmt->execute();
	$tweets=$stmt->fetchAll(PDO::FETCH_OBJ);

	foreach ($tweets as $tweet) {
		$likes=$this->likes($user_id,$tweet->tweetID);
		echo $tweet->tweetBy;
		echo '<div class="all-tweet">
<div class="t-show-wrap">	
 <div class="t-show-inner">
	<!-- this div is for retweet icon 
	<div class="t-show-banner">
		<div class="t-show-banner-inner">
			<span><i class="fa fa-retweet" aria-hidden="true"></i></span><span>Screen-Name Retweeted</span>
		</div>
	</div>
	-->
	<div class="t-show-popup">
		<div class="t-show-head">
			<div class="t-show-img">
				<img src="'.$tweet->profileimage.'"/>
			</div>
			<div class="t-s-head-content">
				<div class="t-h-c-name">
					<span><a href="'.$tweet->username.'">'.$tweet->screenName.'</a></span>
					<span>@'.$tweet->username.'</span>
					<span>'.$tweet->postedOn.'</span>
				</div>
				<div class="t-h-c-dis">
					'.$this->getTweetLinks($tweet->status).'
				</div>
			</div>
		</div>';
		if(!empty($tweet->tweetimage)){

echo'
		<!--tweet show head end-->
		<div class="t-show-body">
		  <div class="t-s-b-inner">
		   <div class="t-s-b-inner-in">
		     <img src="'.$tweet->tweetimage.'" class="imagePopup"/>
		   </div>
		  </div>
		</div>';
	}
	echo '
		<!--tweet show body end-->
	</div>
	<div class="t-show-footer">
		<div class="t-s-f-right">
			<ul> 
				<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
				<li><button class="retweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount"></span></a></button></li>

				<li>'.(($likes['likeOn']===$tweet->tweetID) ? '<button class="unlike-btn" data-li="'. $tweet->likesCount .'" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><a href="#"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.$tweet->likesCount.'</span></a></button>' : '<button class="like-btn" data-li="'. $tweet->likesCount .'" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount>0) ? $tweet->likesCount : '').'</span></a></button>' ).'</li>
					<li>
					<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
					<ul> 
					  <li><label class="deleteTweet">Delete Tweet</label></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
</div>
</div>';
	}
}


public function getTrendByHash($hashtag){
	$stmt=$this->pdo->prepare("SELECT * FROM `trends` WHERE `hashtag` LIKE :hashtag");
	$stmt->bindValue(':hashtag',$hashtag.'%');
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_OBJ);

}

public function getMention($mention){
	$stmt=$this->pdo->prepare("SELECT `user_id`,`username`,`profileimage`,`screenName` FROM `users` Where `username` Like :mention or `screenName` LIKE :mention");
	$stmt->bindValue(':mention',$mention.'%');
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_OBJ);

}
public function addTrend($hashtag){
preg_match_all('/#+([a-zA-Z0-9_]+)/i',$hashtag, $matches);
if($matches){
	$result=array_values($matches[1]);

}
$sql="INSERT INTO `trends` (`hashtag`,`createdOn`) VALUES(:hashtag,CURRENT_TIMESTAMP)";
foreach ($result as $trend) {
	if($stmt=$this->pdo->prepare($sql)){
		$stmt->execute(array(':hashtag'=>$trend));
	}
}
}
public function getTweetLinks($tweet){ 
$tweet=preg_replace("/(https?:\/\/)([\w]+.)([\w\.]+)/", "<a href='$0' target='_blank'>$0</a>", $tweet);

$tweet=preg_replace("/#([\w]+)/", "<a href='".BASE_URL."hashtag/$1'>$0</a>", $tweet);
$tweet=preg_replace("/@([\w]+)/", "<a href='".BASE_URL."hashtag/$1'>$0</a>", $tweet);
return
 $tweet;

}
public function getPopupTweet($tweet_id){
	$stmt=$this->pdo->prepare("SELECT * FROM `tweets`,`users` WHERE `tweetID`=:tweet_id AND `tweetBy` =`user_id`");
	$stmt->bindParam(":tweet_id",$tweet_id,PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_OBJ);

}
public function addLike($user_id,$tweet_id,$get_id){
	$stmt=$this->pdo->prepare("UPDATE `tweets` SET `likesCount`=`likesCount` +1 	WHERE `tweetID`=:tweet_id");
	$stmt->bindParam(":tweet_id",$tweet_id,PDO::PARAM_INT);
	$stmt->execute();
	$this->create('likes',array('likeBy'=>$user_id,'likeOn'=>$tweet_id));
}
public function unLike($user_id,$tweet_id,$get_id){
	$stmt=$this->pdo->prepare("UPDATE `tweets` SET `likesCount`=`likesCount` -1 	WHERE `tweetID`=:tweet_id");
	$stmt->bindParam(":tweet_id",$tweet_id,PDO::PARAM_INT);
	$stmt->execute();

	$stm=$this->pdo->prepare("DELETE FROM `likes` WHERE `likeBy` = :user_id and `likeOn`=:tweet_id");
    $stm->bindParam(":user_id",$user_id);
	$stm->bindParam(":tweet_id",$tweet_id);
	$stm->execute();
	
}
public function likes($user_id,$tweet_id){
	$stmt=$this->pdo->prepare("SELECT * FROM `likes` WHERE `likeBy`=:user_id AND `likeOn`=:tweet_id");
	$stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
	$stmt->bindParam(":tweet_id",$tweet_id,PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function retweet($tweet_id,$user_id,$get_id,$comment){
	$stmt=$this->pdo->prepare("UPDATE `tweets` SET `retweetCount`=`retweetCount` +1 WHERE `tweetID`=:tweet_id");
	$stmt->bindParam(":tweet_id",$tweet_id,PDO::PARAM_INT);
	$stmt->execute();

	$stmt=$this->pdo->prepare("INSERT INTO `tweets` (`status`,`tweetBy`,`tweetimage`,`retweetID`,`retweetBy`,`postedOn`,`likesCount`,`retweetCount`,`retweetMsg`) SELECT `status`,`tweetBy`,`tweetimage`,`tweetID`,:user_id,CURRENT_TIMESTAMP,`likesCount`,`retweetCount`,:retweetMsg FROM `tweets` WHERE `tweetID`=:tweet_id");
		$stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
		$stmt->bindParam(":retweetMsg",$comment,PDO::PARAM_STR);
	$stmt->bindParam(":tweet_id",$tweet_id,PDO::PARAM_INT);
	$stmt->execute();
	
}

}
?>