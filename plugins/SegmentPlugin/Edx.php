<?php

function connect(){
$servername = "172.27.163.65";
$username = "eestay";
$db =  "edxapp";
$password = "lamejorcontraseñatipo";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    return NULL;
    }
}
function getCourses(){
  $conn = connect();
  $sql = "select course_id from student_courseenrollment group by course_id order by created desc";
  $cursor  = $conn->prepare($sql);
  $cursor->execute();
  $result = $cursor->fetchAll();
  $courses = ['Base de datos global'];
  foreach ($result as $key) {
    $courses[] = $key['course_id'];
  }
  return $courses;
}

function getSubscribed($course_id){
  $conn = connect();
  if ($course_id = "Base de datos global"){
    $sql = "select email from auth_user inner join student_courseenrollment where student_courseenrollment.course_id  = ? order by email";
  }
  else {
    $sql = "select email from auth_user order by email";
  }
  $cursor  = $conn->prepare($sql);
  $cursor->execute($course_id);
  $result = $cursor->fetchAll();
  $subscriber = [];
  foreach ($result as $key) {
    $subscriber[] = $key['email'];
  }
  //print_r($subscriber);
  return $subscriber;
}
?>
