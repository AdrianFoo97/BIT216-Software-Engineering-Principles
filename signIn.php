<?php
  session_start();
  include 'dbConnection.php';

  $userName = stripcslashes($_POST['username']);
  $password = stripcslashes($_POST['password']);
  $remember = $_POST['remember'];

  $query = "SELECT * FROM user WHERE username = '$userName' and
          password = '$password'";
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);

  if ($row['username'] == $userName && $row['password'] == $password) {
    if ($row['userType'] == 'Job Seeker') {
      $_SESSION['userName'] = $row['username'];
      header('Location: jobs.html');
    } else {
      $_SESSION['userName'] = $row['username'];
      header('Location: createJob.php');
    }
    if (isset($remember)) {
      $_SESSION['remember'] = $row['username'];
    }
    else {
      unset($_SESSION['remember']);
    }

    echo $_SESSION['userName'];
}
  else {
    header('Location: index.php');
    $_SESSION['userName'] = "failed";
  }

  mysqli_close($connection);
 ?>
