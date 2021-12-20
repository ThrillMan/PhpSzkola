<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Moja Strona</title>
    <style>
      table,th, td{
        border: 1px solid black;
        font-size: 40px;
      }
      th{
        background-color: #3EB489;
      }
      td:last-child{
        text-align: center;
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
        <th>UPDATE</th>
      </tr>
      <!--<a href="powturkaupdate.php?id=$_POST[id]">update</a>-->
    <?php
      $connect=new mysqli("localhost","root","","test");
      $sql="select * from dane;";
      $result=$connect->query($sql);
      while($row=$result->fetch_assoc()){
        echo<<<tab
          <tr>
            <td>$row[id]</td>
            <td>$row[Imie]</td>
            <td>$row[Wiek]</td>
            <td>$row[Urodziny]</td>
            <td><a href="powturkaupdate.php?id=$row[id]">update</a></td>
          </tr>
        tab;
      }
      ?>
      </table>
      <form method="post">
        <input type="submit" name="Add" value="Add">
      </form>
      <form method="post">
        <input type="submit" name="Delete" value="Delete">
      </form>

      <?php
        if(isset($_POST['Add']))
        {
          echo<<<forma
          <form method="post">
            <label for="Imie">Imie</label>
            <input type="text" name="Imie" value="">
            <label for="Urodziny">Data Urodzin</label>
            <input type="date" name="Urodziny" value="">
            <input type="submit" name="Zatwierdź" value="Zatwierdź">
          </form>
          forma;

        }
        if(isset($_POST['Zatwierdź'])){
          $imie=$_POST['Imie'];
          #$wiek=$_POST['Wiek'];
          $wiek=0;
          $data=$_POST['Urodziny'];
          echo $data;
          if($data==""){
            $data=date("Y/m/d");
          }
          if (!$wiek) {
            $wiek=date_diff(date_create($data),date_create(date("Y/m/d")));
            $wiek=$wiek->format('%y');
          }
          $sql="INSERT INTO `dane`(`Imie`, `Wiek`, `Urodziny`) VALUES (\"$imie\",\"$wiek\",\"$data\");";
          $connect->query($sql);
          $connect->close();
          header("Refresh:0");
        }
        if(isset($_POST['Delete'])){
          ?>
          <form method="post">
          <select name="Usuwanie">
            <?php
            $sql="select * from dane;";
            $result=$connect->query($sql);
            while($row=$result->fetch_assoc()){
              echo<<<select
              <option value="$row[id]">Obiekt o ID:$row[id]</option>
              select;
            }
            #$connect->close();
              ?>
          </select>
          <input type="submit" name="UsuwanieSubmit" value="Potwierdz Wybur">
          </form>
          <?php

        }
        if (isset($_POST["UsuwanieSubmit"])) {
          $id=$_POST["Usuwanie"];
          $sql="DELETE FROM `dane` WHERE id=$id";
          $result=$connect->query($sql);
          $connect->close();
          header("refresh: 0");
        }
      #$connect->close();
    #e
      ?>
  </body>
</html>
