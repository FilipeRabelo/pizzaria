<?php

    session_start();

    $user = "root";
    $pass = "";
    $db = "pizzaria";
    $host = "localhost";

    try{

        $conn = new PDO("mysql:host={$host};dbname={$db}", $user, $pass); //CLASSE RESPONSAVEL PELA CONEXAO COM O BANCO DE DADOS
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ATRIBUTOS PARA HABILITAR OS ERROS do PDO
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    } catch (PDOException $e) {

        print "Erro: " . $e->getMessage() . "<br/>";   //SE DER ERRO NA CONEXÃO 
        die();

    }

?>