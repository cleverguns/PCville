<?php
session_start();
if (isset($_SESSION['user_token'])) {
    unset($_SESSION['user_token']);
    session_destroy();
    header("Location: ../");
} else {
    header("Location: ../");
}