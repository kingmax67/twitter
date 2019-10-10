<?php
$error="";  
if(isset($_POST['signup'])){
	$screenName=$_POST['screenName'];
	$password=$_POST['password'];
	$email=$_POST['email'];
	if(empty($screenName) or empty($password) or empty($email)){
$error .="All fields are required";
	}else{
	$email=$getFromU->checkInput($email);
      $password=$getFromU->checkInput($password);
      $screenName=$getFromU->checkInput($screenName);

      if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
  	$error .="<br>invalid email address format";
  }
   if(strlen($screenName)<6 or strlen($screenName)>20){
      $error .="<br>Name must be inbetween 6 - 20 letters";
  }
   if(strlen($password)<5){
	$error .="<br>Your password must be atleast 5 letters";
  }
  	if($getFromU->checkEmail($email)===true){
  		$error .="<br>The email address has already been chosen, Do you want to login Instead?";}
  if($error==""){
 $user_id=$getFromU->create('users',array('email'=>$email,'password'=>md5($password),'screenName'=>$screenName,'profileimage'=>'assets/images/profileimage.png','profileCover'=>'assets/images/defaultCoverImage.png'));
 $_SESSION['user_id']=$user_id;

header('Location:includes/sign-up.php?step=1');
 

  	}
  


}
}

?>
<form method="post">
<div class="signup-div"> 
	<h3>Sign up </h3>
	<ul>
		<li>
		    <input type="text" name="screenName" placeholder="Full Name"/>
		</li>
		<li>
		    <input type="email" name="email" placeholder="Email"/>
		</li>
		<li>
			<input type="password" name="password" placeholder="Password"/>
		</li>
		<li>
			<input type="submit" name="signup" Value="Signup for Twitter">
		</li>
	</ul>
	<?php

	if(isset($error)){
 echo '<li class="error-li">
	  <div class="span-fp-error">'.$error.' </div>
	 </li> ';

		}  ?>
	
	
</div>
</form>