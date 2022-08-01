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

            //MENSAGEM DE ERRO AO ESCOLHER MAIS DE 3 SABORES, SE PASSAR VAI SALVAR OS PEDIDOS!
            $_SESSION["msg"] = "Selecione no Máximo 3 Sabores!!!";
            $_SESSION["status"] = "warning";        
            
        }else{

          //SALVANDO BORDAS E MASSAS NA PIZZA, INSERT / prepara /PREPARANDO A QUERY
          $stmt = $conn->prepare("INSERT INTO pizzas (borda_id, massa_id) VALUES (:borda, :massa)" );

          //FILTRANDO INPUTS
          $stmt->bindParam(":borda", $borda, PDO::PARAM_INT);
          $stmt->bindParam(":massa", $massa, PDO::PARAM_INT);


          //EXECUTANDO
          $stmt->execute();

          
          //RESGATANDO O ULTIMO id DA ULTIMA PIZZA
          $pizzaId = $conn->lastInsertId();


          //SALVANDO OS SABORES DA PIZZA
          $stmt = $conn->prepare("INSERT INTO pizza_sabor (pizza_id, sabor_id) VALUES (:pizza, :sabor)");


            //REPETICAO ATE TERMINAR DE SALVAR TODOS OS SABORES // SALVAR SABOR POR SABOR ATE TERMINAR
            foreach ($sabores as $sabor) {
                
                //FILTRANDO INPUTS
                $stmt->bindParam(":pizza", $pizzaId, PDO::PARAM_INT);
                $stmt->bindParam(":sabor", $sabor,   PDO::PARAM_INT);

                //PARA EXECUTAR O LOOP
                $stmt->execute();

            }

            //CRIAR O PEDIDO DA PIZZA
            $stmt = $conn->prepare("INSERT INTO pedidos(pizza_id, status_id) VALUES (:pizza, :status)");

            //STSTUD SEMPRE COMECA COM 1, QUE É EM PRODUÇÃO
            $statusId = 1;

            //FILTRAR OS INPUTS
            $stmt->bindParam(":pizza", $pizzaId);
            $stmt->bindParam(":status", $statusId);

            //PARA FINALIZAR O PEDIDO
            $stmt->execute();

            //EXIBIR MSG DE SUCESSO
            $_SESSION["msg"]    = "Pedido realizado com sucesso";
            $_SESSION["status"] = "success";
     
        }

        //RETORNA PARA PAGINA INICIAL
        header("Location: ..");    
        
    }

?>