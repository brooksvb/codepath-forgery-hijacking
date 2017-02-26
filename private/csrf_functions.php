<?php

  // Returns a random string suitable for a CSRF token
  function csrf_token() {
    // Requires PHP 7 or later
    return bin2hex(random_bytes(64));
  }

  function create_csrf_token() {
    $token = csrf_token();
    $_SESSION['csrf_token'] = $token;
    $_SESSION['csrf_token_time'] = time();
    return $token;
  }

  function csrf_token_tag() {
    $token = create_csrf_token();
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
  }

  function csrf_token_is_valid() {
    if(!isset($_POST['csrf_token'])) { return false; }
    if(!isset($_SESSION['csrf_token'])) { return false; }
    if(!isset($_SESSION['csrf_token_time'])) { return false; }
    return ($_POST['csrf_token'] === $_SESSION['csrf_token']
            && csrf_token_is_recent());
  }

  // Determines if the form token should be considered "recent"
  // by comparing it to the time a token was last generated.
  function csrf_token_is_recent() {
    $time_limit = 60 * 60 * 10; // Time limit: 10 minutes
    // We can be sure that 'csrf_token_time' is set, because the previous function checked
    return ($_SESSION['csrf_token_time'] + $time_limit) >= time();
  }

?>
