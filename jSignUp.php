<?php
  session_start();
  $serverName = "localhost";
  $dbUserName = "root";
  $dbPassword = "";
  $dbName = "jee";
  $connection = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);

  $userName = stripcslashes($_POST['Susername']);
  $password = stripcslashes($_POST['Spassword']);
  $fullName = stripcslashes($_POST['Sfullname']);
  $email = stripcslashes($_POST['Semail']);
  $phone = stripcslashes($_POST['Sphone']);
  $userType = stripcslashes($_POST['userType']);
  $userName = mysqli_real_escape_string($connection, $userName);
  $password = mysqli_real_escape_string($connection, $password);
  $fullName = mysqli_real_escape_string($connection, $fullName);
  $email = mysqli_real_escape_string($connection, $email);
  $phone = mysqli_real_escape_string($connection, $phone);
  $userType = mysqli_real_escape_string($connection, $userType);

  $query = "SELECT * FROM user WHERE userName = '$userName'";
  $result = mysqli_query($connection, $query);

  unset($_SESSION['userName']);
  if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('sign up failed');</script>";
    $_SESSION['SignUp'] = "failed";
    header("Location: index.php");
  }
  else {
    $query = "INSERT INTO  user (username, password, address, phoneNo, email, userType) VALUES
    ('$userName','$password','','$phone', '$email','$userType')";
    mysqli_query($connection, $query);
    $query3 = "SELECT userID from user where userName='$userName'";
    $result = mysqli_query($connection, $query3);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $userID = $row['userID'];
      }
    }
    $query2 = "INSERT INTO  jobseeker (userID, fullName) VALUES
    ('$userID', '$fullName')";
    mysqli_query($connection, $query2);
    header("Location: index.php");
    $_SESSION['SignUp'] = "success";
  }

  mysqli_close($connection);
?>
