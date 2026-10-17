<?php
require __DIR__ . '/../backend/bootstrap.php';

if (Auth::check()) {
    redirect('admin.php');
}

View::page('login');
