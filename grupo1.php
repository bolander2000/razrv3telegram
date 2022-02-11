<html>
<body>
<?php

	//sql connect authentication
    $servername = "localhost";
    $username = //username;
    $password = //passwd;
    $dbname = //sql database name;

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

?>
		<!-- return button and update button to refresh database and messages --> 
        <a href=home.php>Voltar</a>
        <br>
        <br>
        <form action="/principal.php">
                <input type="submit" value="Atualizar">
        </form>
		<!-- form to get post data to send to enviar.php --> 
	<form action="enviar.php" method="post">
                <label for="user">Texto que deseja enviar:</label><br>
                <input type="text" id="text" name="texto"><br>
                <input type="hidden" id="chat_id" name="chat_id" value=<!--group id value from Telegram stored at SQL-->>
                <input type="hidden" id="group" name="group" value=<!--group name value from Telegram stored at SQL-->>
                <input type="submit" value="Enviar">
        </form>

<?php
	//display all messages stored at MySQL from a selected group by time
    $sql = "SELECT * FROM msg WHERE groupname='grouname' ORDER BY date DESC";//set your SQL groupname
    $resultado = mysqli_query($conn, $sql);

    while($coluna = mysqli_fetch_assoc($resultado)){
?>
	<b>Data : </b><?php echo gmdate("D, d-m-Y H:i:s", $coluna["date"]); ?><br> <!--correct UNIX time to timezone-->
	<b>Grupo : </b><?php echo $coluna["groupname"]; ?><br>
	<b>Nome : </b><?php echo $coluna["sender_fname"]; ?><br>
	<b>Texto : </b><?php echo $coluna["text"]; ?><br>
	<br>
    
<?php
    }
    mysqli_close($conn);
?>
</body>
</html>

