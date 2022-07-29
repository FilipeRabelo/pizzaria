<?php
    include_once("conn.php");

    $method = $_SERVER["REQUEST_METHOD"];

    // SELECT
    if ($method === "GET") { // RESGATE DOS DADOS E MONTAGEM DOS PEDIDOS  SELECT

        $bordasQuery  = $conn->query("SELECT * FROM bordas;");  //BUSCANDO todas as INFORMAÇÕES da tabela do banco
        $bordas  = $bordasQuery->fetchAll();                    // EXECUTANDO COM O METODO FETCH_ALL

        $massasQuery  = $conn->query("SELECT * FROM massas;");
        $massas  = $massasQuery->fetchAll();                    // ARRAY

        $saboresQuery = $conn->query("SELECT * FROM sabores;");
        $sabores = $saboresQuery->fetchAll();   

        // echo "Bordas";
        // echo "<pre>";
        // print_r($bordas);
       
        // echo "Massas";
        // echo "<pre>";
        // print_r($massas);
        
        // echo "Sabores";
        // echo "<pre>";
        // print_r($sabores);
        // exit();

        
    }else if ($method === "POST") { // CRIAÇÃO DO PEDIDO

     
        
    } else {
        # code...
    }
    




?>