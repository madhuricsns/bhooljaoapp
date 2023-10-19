<?php

class Message {
	
	function setMessage($message, $message_type){
		if(strlen(trim($message)) > 0 && strlen(trim($message_type)) > 0){
			switch($message_type){
				case 'success':
				case 'SUCCESS':
					$class = "alert alert-success";
					$scs = "<strong>SUCCESS !!!</strong>";
					break;
				
				case 'error':
				case 'ERROR':
					$class = "alert alert-danger";
					$scs = "<strong>ERROR !!!</strong>";
					break;
					
				case 'warning':	
				case 'WARNING':
					$class = "alert alert-warning";
					$scs = "<strong>WARNING !!!</strong>";
					break;
					
				case 'question':
				case 'QUESTION':
					$class = "alert alert-info";
					$scs = "<strong>QUESTION ???</strong>";
				break;
			}
			$_SESSION['message'] = "<div class='".$class."'><button data-dismiss='alert' class='close' type='button'>x</button>".$scs." ".$message."</div>";
		}else{
			trigger_error("Argument Missing",E_USER_ERROR);
		}
		
	}
	
	function getMessage(){
		if( isset( $_SESSION['message'])){
			$x = $_SESSION['message'];
			unset($_SESSION['message']);
			return $x;
		} else {
			return "";
		}
	}
	
	function customMessage($message, $message_type){
		if(strlen(trim($message)) > 0 && strlen(trim($message_type)) > 0){
			switch($message_type){
				case 'success':
				case 'SUCCESS':
					$class = "alert alert-success";
					break;
				
				case 'error':
				case 'ERROR':
					$class = "alert alert-danger";
					break;
					
				case 'warning':	
				case 'WARNING':
					$class = "alert alert-warning";
					break;
					
				case 'question':
				case 'QUESTION':
					$class = "alert alert-info";
				break;
			}
			return "<div class='".$class."'>".$message."</div>";
		}else{
			trigger_error("Argument Missing",E_USER_ERROR);
		}
	}
}

?>