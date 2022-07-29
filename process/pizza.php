<?php
    include_once("conn.php");

    $method = $_SERVER["REQUEST_METHOD"];

    // SELECT // RESGATE DOS DADOS
    if ($method === "GET") { // RESGATE DOS DADOS E MONTAGEM DOS PEDIDOS  SELECT

        $bordasQuery  = $conn->query("SELECT * FROM bordas;");  //BUSCANDO todas as INFORMAÇÕES da tabela do banco
        $bordas  = $bordasQuery->fetchAll();                    // EXECUTANDO COM O METODO FETCH_ALL

        $massasQuery  = $conn->query("SELECT * FROM massas;");
        $massas  = $massasQuery->fetchAll();                    // ARRAY

        $saboresQuery = $conn->query("SELECT * FROM sabores;");
        $sabores = $saboresQuery->fetchAll();   
        
    }else if ($method === "POST") { // CRIAÇÃO DO PEDIDO

        $data = $_POST;

        $borda   = $data["borda"];
        $massa   = $data["massa"];
        $sabores = $data["sabores"];


        // VALIDAÇÃO DE SABORES MAXIMOS

        if (count($sabores) > 3) {

            $_SESSION["msg"] = "Selecione no Máximo 3 Sabores!!!";
            $_SESSION["status"] = "warning";        
            
        }else{

            echo "Passou da validação";
            exit;
     
        }

        //RETORNA PARA PAGINA INICIAL
        header("Location: ..");    
        
    }

?>