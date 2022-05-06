<?php

// User wants to log out so destroy session:

session_start();
session_unset();
session_destroy();

// No errors -> home Page
header("Location: ../../index.php");
