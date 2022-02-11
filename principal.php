<html>
<body>
<?php
    $token = //token;
    $apiLink = "https://api.telegram.org/bot$token/";
    
	//sql connection authentication
    $servername = "localhost";
    $username = //username;
    $password = //password;
    $dbname = //SQL database name;
    
    //$inc = 0;

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    
	//curl to getupdates JSON from telegrambot
    $rCURL = curl_init();
    curl_setopt($rCURL, CURLOPT_URL, $apiLink.'getUpdates');
    curl_setopt($rCURL, CURLOPT_HEADER, 0);
    curl_setopt($rCURL, CURLOPT_RETURNTRANSFER, 1);
    $update = curl_exec($rCURL);
    curl_close($rCURL);
	
	//decode JSON to array
    $updateArray = json_decode($update, TRUE);
    //print_r($updateArray);
	
	//parse data to SQL 
	if($updateArray['result']){
       	    foreach($updateArray['result'] as $key=>$val){
		
		$update_id = $val['update_id'];
	
		$chat_id = $val['message']['chat']['id'];
		$group = $val['message']['chat']['title'];
		
		$text = $val['message']['text'];
		$date = $val['message']['date'];

		$sender = $val['message']['from'];
                $sender_id = $val['message']['from']['id'];
                $sender_fname = $val['message']['from']['first_name'];
                $sender_lname = $val['message']['from']['last_name'];
                $sender_uname = $val['message']['from']['username'];
		

                //$conn = mysqli_connect($servername, $username, $password);
    		//if (!$conn) {
      		//    die("Connection failed: " . mysqli_connect_error());
   		//}
    
		$sql = "INSERT INTO msg(updateid, chat_id, groupname, text, date, sender_id, sender_fname, sender_lname, sender_uname)
    			VALUES('$update_id', '$chat_id', '$group', '$text', '$date', '$sender_id', '$sender_fname', '$sender_lname', '$sender_uname')";
		
		mysqli_query($conn, $sql);

            
    	$rCURL = curl_init();
    	curl_setopt($rCURL, CURLOPT_URL, $apiLink.'getUpdates?offset='.($update_id+1));
    	curl_setopt($rCURL, CURLOPT_HEADER, 0);
    	curl_setopt($rCURL, CURLOPT_RETURNTRANSFER, 1);
    	curl_exec($rCURL);
    	curl_close($rCURL);
	
	//$inc++; 
        }
	
    } else echo 'No new Updates';
	
	//return to homepage
	
    //echo $inc . " novas mensagens";	
    header('Location: ' . $_SERVER['HTTP_REFERER']);    
?>
</body>
</html> 
