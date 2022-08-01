<?php
    include_once("conn.php");

    //METODO Q ESTA SENDO ENVIADO O FORMULARIO
    $method = $_SERVER["REQUEST_METHOD"];

    //PARA TRAZER OS DADOS
    if($method === "GET") {

        //PRECISAMOS SABER QUAIS SAO OS PEDIDOS Q ESTAO NO SISTEMA E SELECIONAR , BORDA, MASSAS ETC

        $pedidosQuery = $conn->query("SELECT * FROM pedidos;");

        //PARA RESGATAR TODOD OS PEDIDOS
        $pedidos = $pedidosQuery->fetchAll();  // TEMOS TODOS OS PEDIDOS AQUI

        $pizzas = [];

        //MONTANDO PIZZA
        foreach($pedidos as $pedido){

            $pizza = [];  //ESSE ARRAY VAI SER INCREMENTADO PELO FOREACH

            //DEFINIR UM ARRAY PARA A PIZZA
            $pizza["id"] = $pedido["pizza_id"];

            //RESGATaNDO A PIZZA // PRECISO SABER QUAIS SAO OS ID DE MASSA E DE BORDA, DA PIZZA JA SEI
            $pizzaQuery = $conn->prepare("SELECT* FROM pizzas WHERE id = :pizza_id");
           
            $pizzaQuery->bindParam(":pizza_id", $pizza["id"]);  //COMO SOU EU Q ESTOU ADD O ID, EU NAO PRECISO LIMPAR ELE
            
            $pizzaQuery->execute();

            $pizzaData = $pizzaQuery->fetch(PDO::FETCH_ASSOC); // PARA TRAZER UM ARRAY ASSOCIATIVO

            //RESGATANDO A BORDA DA PIZZA
            $bordaQuery = $conn->prepare("SELECT * FROM bordas WHERE id = :borda_id");

            $bordaQuery->bindParam(":borda_id", $pizzaData["borda_id"]);  

            $bordaQuery->execute();

            $borda = $bordaQuery->fetch(PDO::FETCH_ASSOC); 

            $pizza["borda"] = $borda["tipo"];

            //RESGATANDO A massa
            $massaQuery = $conn->prepare("SELECT * FROM massas WHERE id = :massa_id");

            $massaQuery->bindParam(":massa_id", $pizzaData["massa_id"]);

            $massaQuery->execute();

            $massa = $massaQuery->fetch(PDO::FETCH_ASSOC);

            $pizza["massa"] = $massa["tipo"];

            //RESGATANDO OS SABORES DA PIZZA
            $saboresQuery = $conn->prepare("SELECT * FROM pizza_sabor WHERE pizza_id = :pizza_id");

            $saboresQuery->bindParam(":pizza_id", $pizza["id"]);

            $saboresQuery->execute();

            $sabores = $saboresQuery->fetchAll(PDO::FETCH_ASSOC);           

            //RESGATANDO O NOME DOS SABORES
            $saboresDaPizza = []; //ARRAY VAZIO VAI SER INCREMENTADO ;

            $saborQuery = $conn->prepare("SELECT * FROM sabores WHERE id = :sabor_id");

            //RESGATENDO OS SABORES
            foreach ($sabores as $sabor) {

                $saborQuery->bindParam(":sabor_id", $sabor["sabor_id"]);

                $saborQuery->execute();

                $saborPizza = $saborQuery->fetch(PDO::FETCH_ASSOC);

                array_push($saboresDaPizza, $saborPizza["nome"]);
                
            }

            $pizza["sabores"] = $saboresDaPizza;

            //ADICIONANDO O STATUS DO PEDIDO
            $pizza["status"] = $pedido["status_id"];

            //ADICIONANDO O ARRAY DA PIZZA , AO ARRAY DAS PIZZAS
            array_push($pizzas, $pizza);

        }

        // echo"<pre>";
        // print_r($pizzas);

        //RESGATANDO OS STATUS
        $statusQuery = $conn->query("select * from status;");

        $status = $statusQuery->fetchAll();  //FETCH_ALL PARA RECEBER


    //SE FOR POST VAMOS FAZER ATUALIÇÃO , REMOÇÃO ETC...
    }elseif($method === "POST"){


        //VERIFICANDO TIPO DE POST
        $type = $_POST["type"];




        //DELETAR PEDIDO
        if ($type === "delete") {
            
            $pizzaId = $_POST["id"];

            //FILTRANDO 
            $deleteQuery = $conn->prepare("DELETE FROM pedidos WHERE pizza_id = :pizza_id;");

            $deleteQuery->bindParam(":pizza_id", $pizzaId, PDO::PARAM_INT);

            $deleteQuery->execute();

            $_SESSION["msg"]    = "Pedido Removido com Sucesso";
            $_SESSION["status"] = "success";

            
         //ATUALIZAR STATUS DO PEDIDO   
        }else if($type === "update"){   //VERIFICANDO O TIPO

            $pizzaId  = $_POST["id"];
            $statusId = $_POST["status"];

            $updateQuery = $conn->prepare("UPDATE pedidos SET status_id = :status_id WHERE pizza_id = :pizza_id");

            $updateQuery->bindParam(":pizza_id", $pizzaId, PDO::PARAM_INT);
            $updateQuery->bindParam(":status_id", $statusId, PDO::PARAM_INT);

            $updateQuery->execute();

            $_SESSION["msg"]    = "Pedido Atualizado com Sucesso";
            $_SESSION["status"] = "success";

        }
        
        //RETORNA USUARIO PARA O DASHBOARD
        header("Location: ../dashboard.php");
    }

?> 