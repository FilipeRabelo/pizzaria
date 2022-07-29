<?php
include("process/conn.php"); //PARA PEGAR A PAARTE DA SESSAO

$msg = "";

if (isset($_SESSION["msg"])) {

    $msg    = $_SESSION["msg"];    // PARA EXIBIR A MSG
    $status = $_SESSION["status"];

    $_SESSION["msg"]    = "";  // Para limpar a msg e tirar o alerta
    $_SESSION["status"] = "";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css" type="text/css">
    <!-- FONT-AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Faça seu Pedido</title>

</head>

<body style="background-color: rgba(249, 170, 22, 0.662);">

    <header>
        <nav class="navbar navbar-expand-lg">
            <a href="index.php" class="navbar-brand">
                <img src="img/pizza.svg" alt="logo da Pizzaria" id="brand-logo">
            </a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a href="index.php" class="nav-link" id="hover">Peça sua Pizza!</a>
                        <a href="dashboard.php" class="nav-link" id="hover">DashBoard</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <?php if ($msg != "") : ?>
        <div class="alert alert-<?= $status ?>">
            <p><?= $msg ?></p>
        </div>
    <?php endif; ?>