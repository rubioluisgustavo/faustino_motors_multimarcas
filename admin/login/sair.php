<?php

require_once dirname(__DIR__, 2) . '/config.php';
session_start();
session_destroy();

header('Location: ' . site_path() . '/admin/login/');
exit;