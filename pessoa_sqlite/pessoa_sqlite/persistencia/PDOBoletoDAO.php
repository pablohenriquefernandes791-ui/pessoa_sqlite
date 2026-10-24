<?php
/*
 * Persistencia de Boleto com PDO + SQLite
 */
include_once __DIR__ . "/BoletoDAO.php";
class PDOBoletoDAO extends BoletoDAO
{
    private static $instance = NULL;
    private $conn = NULL;

    public static function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new PDOBoletoDAO();
            self::$instance->connect();
        }
        return self::$instance;
    }

    function connect()
    {
        try {
            $this->conn = new PDO('sqlite:' . __DIR__ . '/pessoas.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log('Error: ' . $e->getMessage());
        }
    }

    /* converte string vazia em NULL (campos opcionais) */
    private function nulo($v)
    {
        return ($v === "" || $v === NULL) ? NULL : $v;
    }

    private function parametros($o)
    {
        return array(
            ':data_vencimento' => $this->nulo($o->data_vencimento),
            ':data_emissao' => $this->nulo($o->data_emissao),
            ':data_pagamento' => $this->nulo($o->data_pagamento),
            ':valor' => $this->nulo($o->valor),
            ':desconto' => $this->nulo($o->desconto),
            ':juros' => $this->nulo($o->juros),
            ':multa' => $this->nulo($o->multa),
            ':mora' => $this->nulo($o->mora),
            ':valor_pago' => $this->nulo($o->valor_pago)
        );
    }

    function inserir($objeto)
    {
        try {
            $stmt = $this->conn->prepare('INSERT INTO boleto
                (data_vencimento, data_emissao, data_pagamento, valor, desconto, juros, multa, mora, valor_pago)
                VALUES (:data_vencimento, :data_emissao, :data_pagamento, :valor, :desconto, :juros, :multa, :mora, :valor_pago)');
            $stmt->execute($this->parametros($objeto));
        } catch (PDOException $e) {
            print 'Error: ' . $e->getMessage();
        }
    }

    function alterar($objeto)
    {
        try {
            $stmt = $this->conn->prepare('UPDATE boleto SET
                data_vencimento=:data_vencimento, data_emissao=:data_emissao, data_pagamento=:data_pagamento,
                valor=:valor, desconto=:desconto, juros=:juros, multa=:multa, mora=:mora, valor_pago=:valor_pago
                WHERE id=:id');
            $p = $this->parametros($objeto);
            $p[':id'] = $objeto->id;
            $stmt->execute($p);
        } catch (PDOException $e) {
            print 'Error: ' . $e->getMessage();
        }
    }

    function excluir($id)
    {
        try {
            $stmt = $this->conn->prepare('DELETE FROM boleto WHERE id=:id');
            $stmt->execute(array(':id' => $id));
        } catch (PDOException $e) {
            print 'Error: ' . $e->getMessage();
        }
    }

    function listar()
    {
        $dados = array();
        try {
            $result = $this->conn->query("SELECT * FROM boleto ORDER BY id");
            while ($linha = $result->fetch(PDO::FETCH_ASSOC)) {
                array_push($dados, $linha);
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        return $dados;
    }

    function obter($id)
    {
        $boleto = array();
        try {
            $stmt = $this->conn->prepare("SELECT * FROM boleto WHERE id=:id");
            $stmt->execute(array(':id' => $id));
            if ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $boleto = $linha;
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        return $boleto;
    }
}
?>
