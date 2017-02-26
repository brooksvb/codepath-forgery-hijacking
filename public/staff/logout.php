<?php
require_once('../../private/initialize.php');
require_login();
log_out_user();
redirect_to('login.php');
?>
