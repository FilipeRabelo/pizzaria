<?php
include_once("templates/header.php");
include_once("process/pizza.php");
?>

<div id="main-banner">
    <h1>Faça Seu Pedido</h1>
</div>
<div id="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <h2>Pizzaria La'Delicia</h2>
                <h3>Monte sua Pizza como Desejar:</h3>
                <form action="process/pizza.php" method="POST" id="pizza-form">

                    <div class="form-group">
                        <label for="borda">Borda:</label>
                        <select name="borda" id="borda" class="form-control" required>
                            <option value="">Selecione a Borda da Pizza</option>
                            <?php foreach ($bordas as $borda):  ?>
                                <option value="<?= $borda["id"] ?>"><?= $borda["tipo"] ?></option>
                                <!-- COLUNA TIPO VINDO DO BANCO TABELA BORDAS -->
                                <!-- SALVANDO O ID DA BORDA -->
                            <?php endforeach; ?>
                            <!-- RECEBENDO O AUQUIVO DO PIZZA.PHP -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="massa">Massa:</label>
                        <select name="massa" id="massa" class="form-control" required>
                            <option value="">Selecione a Massa da Pizza</option>
                            <?php foreach ($massas as $massa): ?>
                                <option value="<?= $massa["id"] ?>"><?= $massa["tipo"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sabores">Sabores:(Máximo 3 Sabores)</label>
                        <select multiple name="sabores[]" id="sabores" class="form-control" required>
                            <!-- PARA ENVIAR MAIS DE UM VALOR -->
                            <?php foreach($sabores as $sabor): ?>
                                <option value="<?= $sabor["id"] ?>"><?= $sabor["nome"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Fazer Pedido">
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<?php
include_once("templates/footer.php");
?>