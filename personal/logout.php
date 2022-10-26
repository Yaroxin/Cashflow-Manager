<?php
	session_start();
	session_destroy();

	setcookie('login', null, -1, '/');
	setcookie('email', null, -1, '/');
	setcookie('key', null, -1, '/');

	header('location:/');