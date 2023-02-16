<?php
require_once("conn.php");
global $yhendus;
if(isset($_REQUEST["lisamine"])){
    $kask=$yhendus->prepare("UPDATE kohviautomaat SET topsepakis=topsepakis+1 WHERE Id=?");
    $kask->bind_param('s',$_REQUEST['lisamine']);
    $kask->execute();
}
?>
<!doctype html>
<html>
<head>
    <title>Admin automaat</title>
    <link rel="stylesheet" href="automaatstyle.css">
</head>
<body>
<h1>Admin automaat</h1>
<table class="admin_table">
<tr>
    <th>Id</th>
    <th>Jooginimi</th>
    <th>Topsepakis</th>
    <th>Lisa pakis</th>
</tr>
<br>
<?php
$kask=$yhendus->prepare(
    "SELECT Id, jooginimi, topsepakis, topsejuua FROM kohviautomaat;");
$kask->bind_result($id, $nimi, $pakis, $juua);
$kask->execute();
while($kask->fetch()){
    echo "
        <tr>
            <td>$id</td>
            <td>$nimi</td>
            <td>$pakis</td>
            <!--<form action='?'>-->
            <td><input type='number' value='1' name='uus_pakis'>
            <!--<input type='submit' value='+' name=$nimi>-->
            <a href='?lisamine=$id'>+</a></td>
            <!--</form>-->
        </tr>
    ";
}

?>
</table>
<a href="automaat.php" Id="tagasi">Tagasi</a>
</body>
</html>
