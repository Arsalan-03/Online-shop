<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /get_login.php");
}

$user = $_SESSION['user_id'];
$pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
$statement = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
$statement->execute(['user_id' => $user]);
$profileUsers = $statement->fetchAll();
require_once 'my_profile.php';

