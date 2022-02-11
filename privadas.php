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
<?php
//display all private messages stored at MySQL by time
    $sql = "SELECT * FROM msg WHERE groupname='' ORDER BY date DESC";
    $resultado = mysqli_query($conn, $sql);

    while($coluna = mysqli_fetch_assoc($resultado)){
?>
	<b>Data : </b><?php echo gmdate("D, d-m-Y H:i:s", $coluna["date"]); ?><br><!--correct UNIX time to timezone-->
	<b>Nome : </b><?php echo $coluna["sender_fname"]; ?><br>
	<b>Texto : </b><?php echo $coluna["text"]; ?><br>
	<br>
    
<?php
    }
    mysqli_close($conn);
?>
</body>
</html>

