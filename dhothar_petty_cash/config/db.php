<?php
$con = mysqli_connect("localhost", "dhothari_cms", "dhothari_cms", "dhothari_petty_cash");
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error() ." | Seems like you haven't created the DATABASE with an exact name";
  }
?>