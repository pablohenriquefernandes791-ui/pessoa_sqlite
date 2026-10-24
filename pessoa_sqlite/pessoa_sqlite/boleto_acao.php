<?php
/*
 * Controlador do CRUD de Boleto
 */
require_once "boleto.php";
require_once "persistencia/PDOBoletoDAO.php";

if (!defined("DESTINO_BOLETO"))
    define("DESTINO_BOLETO", "boleto_list.php");

$acao = "";
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
        break;
    case 'POST':
        $acao = isset($_POST['acao']) ? $_POST['acao'] : "";
        break;
}

switch ($acao) {
    case 'Salvar':
        salvar_boleto();
        break;
    case 'Alterar':
        alterar_boleto();
        break;
    case 'excluir':
        excluir_boleto();
        break;
}

/* converte o formulário em objeto Boleto */
function tela2objeto()
{
    $campos = array('id', 'data_vencimento', 'data_emissao', 'data_pagamento',
        'valor', 'desconto', 'juros', 'multa', 'mora', 'valor_pago');
    $b = new Boleto();
    foreach ($campos as $c) {
        $b->$c = isset($_POST[$c]) ? $_POST[$c] : "";
    }
    return $b;
}

function carregar_boleto($id)
{
    return PDOBoletoDAO::getInstance()->obter($id);
}

function salvar_boleto()
{
    PDOBoletoDAO::getInstance()->inserir(tela2objeto());
    header("location:" . DESTINO_BOLETO);
}

function alterar_boleto()
{
    PDOBoletoDAO::getInstance()->alterar(tela2objeto());
    header("location:" . DESTINO_BOLETO);
}

function excluir_boleto()
{
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    PDOBoletoDAO::getInstance()->excluir($id);
    header("location:" . DESTINO_BOLETO);
}
?>
