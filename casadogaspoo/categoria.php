<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style/estilo.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="banner">
            <h1>Casa do Gás</h1>
        </div>

        <div style="overflow:auto">
            <div class="menu">
                <a href="index.php">Home</a>
                <a href="categoria.php">Categoria</a>
                <a href="cidade.php">Cidade</a>
                <a href="fornecedor.php">Fornecedor</a>
                <a href="produto.php">Produto</a>
                <a href="cliente.php">Cliente</a>
                <a href="departamento.php">Departamento</a>
                <a href="funcionario.php">Funcionário</a>
            </div>

            <div class="main">
                <h2>Categoria</h2>
                <?php
                require_once 'class/class_categoria.php';

                $oCategoria = new Categoria();

                if (isset($_GET['acao']) && $_GET['acao'] == 'deletar') {
                    $oCategoria->setCodigo($_GET['registro']);
                    $oCategoria->deletar();
                }

                $oCategoria->montaTabela();
                ?>
            </div>
        </div>

        <div id="footer">Osmar Fagundes Distribuidora de Gás M.E. - Rio do Sul - SC, Rua Duque de Caxias, 180 - 47.3531.1500</div>

    </body>
</html>