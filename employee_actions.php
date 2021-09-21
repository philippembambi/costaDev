<?php
/*
$servername = "localhost";
$username = "costa";
$password = "costa";
$dbname = "flutter_db";
*/
$table = "Employees";

if(!empty($_POST['action'])) {
$action = $_POST['action'];
}
elseif(!empty($_GET['action'])){
    $action = $_GET['action'];
}
else{
    $action = $_REQUEST['action'];
}
try{

    $con=new PDO('mysql:host=localhost;dbname=flutter_db','costa','costa'); 
                 $con->exec("SET names utf8");
                 
}catch(PDOException $ex){
    die("Erreur ".$ex->getMessage());
    //return ("Erreur ".$ex->getMessage());
}

/*
$connex = new mysqli($servername, $username, $password, $dbname);
if($connex->connect_error) {
    die("Connection failed : ".$connex->connect_error );
    return;
}
*/

// If the app sends action to create table
if("CREATE_TABLE" == $action) {
try{
    $q = $con->prepare('CREATE TABLE IF NOT EXISTS Employees (
        id INT(6) AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(30) NOT NULL,
        last_name VARCHAR(30) NOT NULL)');
            $q->execute();
            $q->CloseCursor(); 
            echo 'success';
    }
    catch(PDOException $ex) {
        echo 'error';
    }
}
 /*
 $sql = "CREATE TABLE IF NOT EXISTS $table (
     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
     first_name VARCHAR(30) NOT NULL,
     last_name VARCHAR(30) NOT NULL)";

     if($connex->query($sql) === TRUE ) {
           echo 'success';
     } else{
         echo 'error';
     }
     $connex->close();
     return;
}
*/

if("GET_ALL" == $action) {
try{
$db_data = array();
$q = $con->prepare('SELECT id_el, el_noms, el_sexe  FROM eleve');
$q->execute();

while ($data = $q->fetch())
{
    $db_data[] = $data;
}
echo json_encode($db_data);
$q->CloseCursor();
}
catch(PDOException $ex) {
    echo 'error';
}

}

/*
    $sql = "SELECT id, first_name, last_name FROM $table ORDER BY id DESC";
    $result = $connex->query($sql);

    if($result->num_rows > 0) {
       while($row = $result->fetch_assoc()) {
           $db_data[] = $row;
       }
       echo json_encode($db_data);
    }else{
        echo 'error';
    }
    $connex->close();
    return;
}
*/

if("ADD_EMP" == $action) {
/*
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
*/
    $noms =  $_POST['noms'];
    $sexe =  $_POST['sexe'];
    $lieu =  $_POST['lieuNaissance'];
    $date =  $_POST['dateNaissance'];
    try{
        $q = $con->prepare('INSERT INTO eleve(el_noms, el_sexe, el_lieu_naissance) 
                            VALUES(:el_noms, :el_sexe, :el_lieu_naissance)');
                $q->bindValue(':el_noms', $noms, PDO::PARAM_STR);
                $q->bindValue(':el_sexe', $sexe, PDO::PARAM_STR);
                $q->bindValue(':el_lieu_naissance', $sexe, PDO::PARAM_STR);
                $q->execute();
                $q->CloseCursor(); 
                echo 'success';
        }
        catch(PDOException $ex) {
            echo 'error';
        }
/*
    $sql = "INSERT INTO $table (first_name, last_name) VALUES($first_name, $last_name)";
    $result = $connex->query($sql);
    echo "success";
    $connex->close();
    return;
    */
}

if("DELETE_EMP" == $action) {
    
    $emp_id = $_POST['emp_id'];
    try{
        $q = $con->prepare('DELETE FROM Employees WHERE id = :id');
                $q->bindValue(':id', $emp_id, PDO::PARAM_STR);
                $q->execute();
                $q->CloseCursor(); 
                echo 'success';
        }
        catch(PDOException $ex) {
            echo 'error';
        }

        /*
    $emp_id = $_POST['emp_id'];
    $sql = "DELETE FROM $table WHERE id = $emp_id";
    if($connex->query($sql) === TRUE) {
        echo 'success';
    }
    else {
        echo 'error';
    }
    $connex->close();
    return;
    */
}
?>