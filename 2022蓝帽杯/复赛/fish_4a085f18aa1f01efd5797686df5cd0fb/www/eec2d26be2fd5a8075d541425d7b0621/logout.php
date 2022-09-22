<?php
session_start();
session_unset($_SESSION['username']);
header("Location: login.php");