<?php
/*
 * Formulário de inclusão/edição de Boleto
 */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<?php include 'cabecalho.php'; ?>
<?php
include "boleto_acao.php";
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$d = array();
if ($id != 0)
    $d = carregar_boleto($id);

/* devolve o valor do campo (vazio se for inclusão) */
function v($d, $campo)
{
    return isset($d[$campo]) ? htmlspecialchars($d[$campo]) : "";
}
?>

<body>
    <header class="container">
        <?php include 'menu.php'; ?>
    </header>
    <main class="container">
        <form action="boleto_acao.php" method="post">
            <fieldset>
                <legend>Cadastro de Boletos</legend>

                <label for="id">Id</label>
                <input type="text" name="id" id="id" value="<?= $id ?>" readonly><br>

                <label for="data_vencimento">Data de vencimento</label>
                <input type="date" name="data_vencimento" id="data_vencimento" value="<?= v($d, 'data_vencimento') ?>" required><br>

                <label for="data_emissao">Data de emissão</label>
                <input type="date" name="data_emissao" id="data_emissao" value="<?= v($d, 'data_emissao') ?>" required><br>

                <label for="data_pagamento">Data de pagamento</label>
                <input type="date" name="data_pagamento" id="data_pagamento" value="<?= v($d, 'data_pagamento') ?>"><br>

                <label for="valor">Valor</label>
                <input type="number" step="0.01" min="0" name="valor" id="valor" value="<?= v($d, 'valor') ?>" required><br>

                <label for="desconto">Desconto</label>
                <input type="number" step="0.01" min="0" name="desconto" id="desconto" value="<?= v($d, 'desconto') ?>"><br>

                <label for="juros">Juros</label>
                <input type="number" step="0.01" min="0" name="juros" id="juros" value="<?= v($d, 'juros') ?>"><br>

                <label for="multa">Multa</label>
                <input type="number" step="0.01" min="0" name="multa" id="multa" value="<?= v($d, 'multa') ?>"><br>

                <label for="mora">Mora</label>
                <input type="number" step="0.01" min="0" name="mora" id="mora" value="<?= v($d, 'mora') ?>"><br>

                <label for="valor_pago">Valor pago</label>
                <input type="number" step="0.01" min="0" name="valor_pago" id="valor_pago" value="<?= v($d, 'valor_pago') ?>"><br>

                <input class="primary" type="submit" name="acao" id="acao" value="<?= $id == 0 ? "Salvar" : "Alterar" ?>">
                <input type="reset" value="Cancelar" />
            </fieldset>
        </form>
    </main>
    <footer class="container"></footer>
</body>

</html>
