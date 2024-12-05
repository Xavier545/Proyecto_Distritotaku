<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $servername = "db";
        $username = "mysql";
        $password = "mysecret";
        $dbname = "mydb";
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $sql = "CREATE TABLE IF NOT EXISTS USER (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          firstname VARCHAR(30) NOT NULL,
          lastname VARCHAR(30) NOT NULL,
          email VARCHAR(50)
          );";
          
        if ($conn->query($sql) === TRUE) {
          echo "Table USER created successfully";
        } else {
          echo "Error creating table: " . $conn->error;
        }
        
        $sql = "SELECT * FROM USER;";
        $result = $conn->query($sql);
        if(mysqli_num_rows($result) == 0){
          $users = [
            ["LUIS JORGE","BARRACHINA BUESO", "lbarra@gmail.com"],
            ["CARLOS ANTONIO","EGEA HERNANDEZ", "cegea@gmail.com"],
            ["CESAR LUIS","BLASCO ESCUREDO","cblasco@gmail.com"],
            ["MANUEL","GARCIA GIRONA","mgarcia@gmail.com"],
            ["ADOLFO","VIDAGANY GISBERT","avida@gmail.com"]
          ];
          for($i = 0; $i < 5; $i++){
            $sql = "INSERT INTO USER (firstname, lastname, email) values('" . $users[$i][0] . "','" . $users[$i][1] . "','" . $users[$i][2] . "');";
            $conn->query($sql);
          }
        }
                        
        $sql = "SELECT id, firstname, lastname FROM USER;";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
          }
        } else {
          echo "0 results";
        }
        $conn->close();
    ?>
</body>
</html>