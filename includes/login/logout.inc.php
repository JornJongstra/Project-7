<?php

session_start();
session_unset();
session_destroy();

header("location: ../../front-end/algemeen/index.php");
exit();