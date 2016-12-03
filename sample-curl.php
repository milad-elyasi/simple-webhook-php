<?php
// checking the login
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


//api
	$api_key='AA6-8qRX7rU*V#%KP!HJa%@jWUv37$syDf&ZA-a_Z3YKtx#zNv';
	
	if(isset($_POST['name']) && isset($_POST['text'])){
			include_once('../config/conn.php');
	        $conn=connection();
		function call($error,$wy,$msg){
        $call = array('error'=>$error,'wy'=>$wy,'ms'=>$msg);
        echo json_encode($call);
}
         // EXAMPLE DATA : name , description
		$name=base64_encode(urlencode(strip_tags(stripcslashes(trim(mysqli_real_escape_string($conn,$_POST['name']))))));
		$text=base64_encode(urlencode(strip_tags(stripcslashes(trim(mysqli_real_escape_string($conn,$_POST['text']))))));
		$api_final=urlencode($api_key);
		echo $api_final;
		$date=date('Y-m-d');
		$postfields = array('api'=>$api_key, 'name'=>$name,'text'=>$text,'date'=>$date);
		//sending
		$request_url='URL_TO_POST_DATA'; // url for change 
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!
		$result = curl_exec($ch); // true or false
		if($result){
			// getting the user id 
			$user_id=1;
			// insering
			$insert="INSERT INTO form(id,user_id,name,text,date) VALUES('','$user_id','$name','$text','$date')";
	
            if($query=mysqli_query($conn,$insert)){
				// success
						call('false','ok!','done!');
	                 	return true;
			}
	else{
		         //sql error
					call('true','1','err1');
	}			
		}
			else{
				//curl error	
				$err=curl_error($ch).curl_errno($ch);
				call('true','2',$err);
		
	}
	
	}
		else{
		//data is not completed
		call('true','3','err3');
	}

}
	else{
		//post
		call('true','4','err4');
	}















?>
