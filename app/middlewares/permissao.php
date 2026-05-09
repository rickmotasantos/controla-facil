<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function somenteAdmin()
{
    if ($_SESSION['tipo'] !== 'admin') {

        $_SESSION['msg'] = "Acesso negado!";
        $_SESSION['msg_tipo'] = "danger";

        header("Location: index.php?action=home");
        exit;
    }
}

function somenteEmpresa()
{
    if (
        $_SESSION['tipo'] !== 'admin' &&
        $_SESSION['tipo'] !== 'empresa'
    ) {

        $_SESSION['msg'] = "Acesso negado!";
        $_SESSION['msg_tipo'] = "danger";

        header("Location: index.php?action=home");
        exit;
    }
}

function somenteVendas()
{
    if (
        $_SESSION['tipo'] !== 'funcionario' &&
        $_SESSION['tipo'] !== 'admin' &&
        $_SESSION['tipo'] !== 'empresa'
    ) {

        $_SESSION['msg'] = "Acesso negado!";
        $_SESSION['msg_tipo'] = "danger";

        header("Location: index.php");
        exit;
    }
}