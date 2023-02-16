<?php
require_once("conn.php");
global $yhendus;
//global $kood;
//global $pakis;
?>
<?php
$query = null;

if (isset($_GET['query'])) {
    $query = (string)$_GET['query'];
}
if (isset($_GET['one'])) {
    $query .= (string)$_GET['one'];
}
if (isset($_GET['kustuta'])){
    $query = null;
    header("Location: $_SERVER[PHP_SELF]");
}
$kask=$yhendus->prepare(
    "SELECT Id, jooginimi, topsepakis, topsejuua, kood FROM kohviautomaat WHERE topsepakis>0;");
$kask->bind_result($id, $nimi, $pakis, $juua, $kood);
$kask->execute();
while($kask->fetch()){
    if (isset($_GET['tellima'])){
        if ($query== $kood) {
            $juua = $_GET["juua"];
            if ($pakis >= $juua) {
                $Uus_pakis = $pakis - $juua;
                $Uus_kood=$kood;
                $kask->close();
                $kask = $yhendus->prepare("UPDATE kohviautomaat SET topsepakis=? WHERE kood=?");
                $kask->bind_param("is",$Uus_pakis,$query);
                $kask->execute();
                //$kask->close();
                $query = null;
                header("Location: $_SERVER[PHP_SELF]");
        }
        else{
          $query = null;  
        }
        
    }
}
if (isset($_REQUEST['Parool'])){
    if($_REQUEST["text_parool"]=="1234"){
       header("Location: admin_automaat.php"); 
    }
}
    //header("Location: $_SERVER[PHP_SELF]");
    /*$kask=$yhendus->prepare(
        "SELECT Id, jooginimi, topsepakis, topsejuua, kood FROM kohviautomaat WHERE topsepakis>0;");
    $kask->bind_result($id2, $nimi2, $pakis2, $juua2, $kood2);
    $kask->execute();
    while($kask->fetch()){
        if ((int)$_GET["res"]== $kood2){
            $juua2=(int) $_GET["juua"];
            if ($pakis2<$juua2){

            }
            else{
                $pakis2=$pakis2-$juua2;
                $kask=$yhendus->prepare("UPDATE kohviautomaat SET topsepakis='$pakis2' WHERE kood='$kood2'");
                $kask->bind_param("i", $pakis2, $kood2);
                $kask->execute();
            }
        }
    }*/
}
?>
<!doctype html>
<html>
<head>
    <title>Automaat</title>
    <link rel="stylesheet" href="automaatstyle.css">
</head>
<body>
<h1>Kohviautomaat</h1>
<table class="joogid">
    <tr>
        <?php
        $kask=$yhendus->prepare(
            "SELECT Id, jooginimi, topsepakis, topsejuua, kood FROM kohviautomaat WHERE topsepakis>0;");
        $kask->bind_result($id, $nimi, $pakis, $juua, $kood);
        $kask->execute();
        while($kask->fetch()) {
            echo "<tr>";
            echo "<td>$nimi</td>";

            echo "<td>number: $kood</td>";
            echo "</tr>";
        }
        $kask->close();
        ?>
    </tr>

</table>
<form name='form' action='' method='GET' Id="arved">
    <div class="tekst_osa">
        <input type="hidden" name="query" value="<?= htmlspecialchars($query) ?>">
        <input type='text' name='res' style='grid-area: result' value='<?= $query ?>' ;>
    </div>
    <table Id="arved">
        <tr>
            <td><input type='submit' name='one' value='1' Id="one"></td>
            <td><input type='submit' name='one' value='2' Id="one"></td>
            <td><input type='submit' name='one' value='3' Id="one"></td>
        </tr>
        <tr>
            <td><input type='submit' name='one' value='4' Id="one"></td>
            <td><input type='submit' name='one' value='5' Id="one"></td>
            <td><input type='submit' name='one' value='6' Id="one"></td>
        </tr>
        <tr>
            <td><input type='submit' name='one' value='7' Id="one"></td>
            <td><input type='submit' name='one' value='8' Id="one"></td>
            <td><input type='submit' name='one' value='9' Id="one"></td>
        </tr>
        <tr>
            <td><input type="submit" name="kustuta" value="X" Id="kustuta"></td>
            <td><input type='submit' name='one' value='0' Id="one"></td>
            <td><input type="submit" name="tellima" value="+" Id="telli"></td>
        </tr>
    </table>
    <input type="number" name="juua" value="1" Id="arv">
</form>
<br>
<form action="?" class="parool">
    <input type="text" name="text_parool" placeholder="Sisesta parool" Id="parool_sisesta">
    <br>
    <input type="submit" name="Parool" value="Sisesta" Id="nupp_parool"> 
</form>
</body>
</html>
