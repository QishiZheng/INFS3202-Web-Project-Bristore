<?php
	function Login(){
    	if(empty($_POST['emailaddress'])){
       		$this->HandleError("Email Address is empty!");
       	 	return false;
    	}
    
    	if(empty($_POST['password'])){
        	$this->HandleError("Password is empty!");
        	return false;
    	}
    
    	$emailaddress = trim($_POST['emailaddress']);
    	$password = trim($_POST['password']);
    
    	if(!$this->CheckLoginInDB($emailaddress,$password)){
        	return false;
    	}
    
    	session_start();
    
    	$_SESSION[$this->GetLoginSessionVar()] = $emailaddress;
    
   	 	return true;
	}
	
	function CheckLoginInDB($emailaddress,$password){
    	if(!$this->DBLogin()){
       		$this->HandleError("Database login failed!");
        	return false;
    	}          
    	$emailaddress = $this->SanitizeForSQL($emailaddress);
    	$pwdmd5 = md5($password);
    	$qry = "Select userName, emailAddress from $this->USER ".
        " where emailAddress='$emailaddress' and password='$pwdmd5' ".
        " and confirmcode='y'";
    
    	$result = mysql_query($qry,$this->connection);
    
    	if(!$result || mysql_num_rows($result) <= 0) {
       		 $this->HandleError("Error logging in. ".
            "The Email Address or password does not match");
        	return false;
    	}
    return true;
}

?>