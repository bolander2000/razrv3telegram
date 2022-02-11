<html>
<body>

<?php

//post data from group php

$token = //token;
$apiLink = "https://api.telegram.org/bot$token/";
$texto = $_POST["texto"];
$chat_id = $_POST["chat_id"];
$group = $_POST["group"];

//sql connect authentication

    $servername = "localhost";
    $username = //username;
    $password = //password;
    $dbname = //sql database name;

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }


if ($texto!=""){
	
	//write message to be sent into SQL database for display
    $update_id = "69420"; //random database integer requirement by SQL
    $sender_id = "69420"; //random database integer requirement by SQL
    $sender_lname =//name you want to register;
     
    $sender_fname = //name you want to register;
    $sender_uname = //name you want to register;
    $date = time(); //set timezone by adding or subtracting seconds from UNIX time
		
	//sql command
    $sql = "INSERT INTO msg(updateid, chat_id, groupname, text, date, sender_id, sender_fname, sender_lname, sender_uname)
                        VALUES('$update_id', '$chat_id', '$group', '$texto', '$date', '$sender_id', '$sender_fname', '$sender_lname', '$sender_uname')";

    mysqli_query($conn, $sql);
	
	//CURL to send message to Telegram Bot API
    $rCURL = curl_init();
    curl_setopt($rCURL, CURLOPT_URL, $apiLink.'sendMessage?chat_id=' . $chat_id .'&text=' . $texto);
    curl_setopt($rCURL, CURLOPT_HEADER, 0);
    curl_setopt($rCURL, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($rCURL);
    curl_close($rCURL);


    echo "Mensagem enviada!";
}
else
	echo "Sem Texto";

?>

</body>
</html> 
