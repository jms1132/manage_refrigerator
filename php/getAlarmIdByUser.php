<?php
    //mysqli_connect([아이피], [아이디], [비밀번호], [DB명]);
    require_once('dbConnect.php');

    // $id = "1";
    $id = $_POST["id"];

    $statement = mysqli_prepare($con, "SELECT name, alarmID, expirationDate FROM foodTBL WHERE code in (SELECT manageTBL.code FROM manageTBL WHERE manageTBL.id = ?)");

    mysqli_stmt_bind_param($statement, "s", $id);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    $data = array();
    if($result){

      while($row=mysqli_fetch_array($result)){
        array_push($data,
            array("name"=>$row[0], "alarmID"=>$row[1], "expirationDate"=>$row[2]
        ));
    }

    header('Content-Type: application/json; charset=utf8');
    $json = json_encode(array("food"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    echo $json;

  }
  else{
      echo "SQL문 처리중 에러 발생 : ";
      echo mysqli_error($con);
  }

  mysqli_close($con);

?>
