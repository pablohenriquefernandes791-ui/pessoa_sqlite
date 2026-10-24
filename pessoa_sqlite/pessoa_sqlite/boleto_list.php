<?php
/*
 * Listagem de Boleto
 */
?>
<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<?php include 'cabecalho.php'; ?>
<?php require_once 'boleto_acao.php'; ?>

<body>
    <main class="container">
        <?php include 'menu.php'; ?>
        <?php
        $dados = PDOBoletoDAO::getInstance()->listar();
        if (($dados == NULL) || (count($dados) == 0)) {
            echo "<div><span class='warning'>sem dados a serem exibidos</span></div>";
        }
        ?>
        <table role="grid">
            <tr>
                <th>Id</th>
                <th>Vencimento</th>
                <th>Emissão</th>
                <th>Pagamento</th>
                <th>Valor</th>
                <th>Desconto</th>
                <th>Juros</th>
                <th>Multa</th>
                <th>Mora</th>
                <th>Valor pago</th>
                <th>Alterar</th>
                <th>Excluir</th>
            </tr>
            <?php
            foreach ($dados as $b)
                echo "<tr><td>{$b['id']}</td>
                  <td>{$b['data_vencimento']}</td>
                  <td>{$b['data_emissao']}</td>
                  <td>{$b['data_pagamento']}</td>
                  <td>{$b['valor']}</td>
                  <td>{$b['desconto']}</td>
                  <td>{$b['juros']}</td>
                  <td>{$b['multa']}</td>
                  <td>{$b['mora']}</td>
                  <td>{$b['valor_pago']}</td>
                  <td align='center'><a role='button' href='boleto_cad.php?id={$b['id']}'>A</a></td>
                  <td align='center'><a role='button' href=\"javascript:excluirRegistro('boleto_acao.php?acao=excluir&id={$b['id']}');\">E</a></td>
              </tr>";
            ?>
        </table>
    </main>
    <script>
        function excluirRegistro(url) {
            if (confirm("Confirmar Exclusão?"))
                location.href = url;
        }
    </script>
</body>

</html>
