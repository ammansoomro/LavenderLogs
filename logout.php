<?php
require 'config/constants.php';
//Destroy all sessions
session_destroy();
header('location:' . ROOT_URL);
die();
