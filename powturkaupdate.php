<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>UpdatE??</title>
    <style>
      table,th, td{
        border: 1px solid black;
        font-size: 40px;
      }
      th{
        background-color: #3EB489;
      }
    </style>
  </head>
  <body>
    <table>
      <tr>
        <th>ID</th>
        <th>IMIE</th>
        <th>WIEK</th>
        <th>DATA URODZIN</th>
      </tr>
    <?php
    $id=$_GET["id"];
    $connect=new mysqli("localhost","root","","test");
    $sql="select * from dane where id=$id";
    $result=$connect->query($sql);
    while($row=$result->fetch_assoc()){
      echo<<<tab
        <tr>
          <td>$row[id]</td>
          <td>$row[Imie]</td>
          <td>$row[Wiek]</td>
          <td>$row[Urodziny]</td>
        </tr>
      tab;
    }

     ?>
     </table>
     Chcesz zamienić na<br>
     <form method="post">
       <label for="Imie">Imie</label>
       <input type="text" name="Imie" value="">

       <label for="Urodziny">Data Urodzin</label>
       <input type="date" name="Urodziny" value="">
       <input type="submit" name="Zatwierdź" value="Zatwierdź">
     </form>
     <?php
     $sql="select * from dane where id=$id";
     $result=$connect->query($sql);
     while($row=$result->fetch_assoc()){
          $imie_default=$row["Imie"];
          $date_default=$row["Urodziny"];
     }
     if(isset($_POST['Zatwierdź'])){
       if($_POST['Imie']==""){
         $imie=$imie_default;
       }
       else{
         $imie=$_POST['Imie'];
       }

       if($_POST['Urodziny']==""){
         $data=$date_default;
       }
       else{
         $data=$_POST['Urodziny'];
       }
       $wiek=date_diff(date_create($data),date_create(date("Y/m/d")));
       $wiek=$wiek->format('%y');
       $sql="UPDATE `dane` SET `Imie`='$imie',`Wiek`='$wiek',`Urodziny`='$data' WHERE id=$id";
       $connect->query($sql);
       $connect->close();
       header("location: powturkaphp.php");
     }
      ?>

  </body>
</html>
