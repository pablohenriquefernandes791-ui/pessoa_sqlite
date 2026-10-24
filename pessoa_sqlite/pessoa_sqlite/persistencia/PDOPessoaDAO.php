<?php
/*
 * Código de exemplo da utilização de PDO como persistencia
 * Classe abstrata para persistencia de Pessoa
 * @author Wesley R. Bezerra <wesley.bezerra@ifc.edu.br>
 * @version 0.1
 *
 */
include_once __DIR__ . "/PessoaDAO.php";
class PDOPessoaDAO extends PessoaDAO
{
    private static $instance = NULL;
    private $conn = NULL;
    function PDOPessoaDAO()
    {
        $this->connect();
    }

    public static function getInstance()
    {
        if (self::$instance == NULL)
            self::$instance = new PDOPessoaDAO();        
        return self::$instance;
    }

    /*
     * Método faz a conexao com o recurso usado
     * @return void
     */
    function connect()
    {
        try {
            $this->conn = new PDO('sqlite:' . __DIR__ . '/pessoas.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log('Error: ' . $e->getMessage());
        }
    
    }
    /*
     * Método que insere dados no sistema de persistencia
     * @param $objeto Pessoa objeto que será inserido 
     * @return void
     */
    function inserir($objeto)
    {
        try {
            $this->conn = new PDO('sqlite:' . __DIR__ . '/pessoas.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->conn->prepare('INSERT INTO pessoa (nome, peso, altura, email, cidade) 
                 VALUES(:nome, :peso, :altura, :email, :cidade)');
            $stmt->execute(
                array(
                    ':nome' => $objeto->nome,
                    ':altura' => $objeto->altura,
                    ':peso' => $objeto->peso,
                    ':email' => $objeto->email,
                    ':cidade' => $objeto->cidade
                )
            );
            print $stmt->rowCount();
        } catch (PDOException $e) {
            print 'Error: ' . $e->getMessage();
        }

    }
    /*
     * Método que altera dados no sistema de persistencia
     * @param $objeto Pessoa objeto que será inserido 
     * @return void
     */
    function alterar($objeto)
    {
        try {
            $this->conn = new PDO('sqlite:' . __DIR__ . '/pessoas.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->conn->prepare('UPDATE pessoa SET nome=:nome,altura=:altura,peso=:peso,email=:email,cidade=:cidade 
                  WHERE id=:id');
            $stmt->execute(
                array(
                    ':nome' => $objeto->nome,
                    ':altura' => $objeto->altura,
                    ':peso' => $objeto->peso,
                    ':email' => $objeto->email,
                    ':cidade' => $objeto->cidade,
                    ':id' => $objeto->id
                )
            );
            print $stmt->rowCount();
        } catch (PDOException $e) {
            print 'Error: ' . $e->getMessage();
        }
    }
    /*
     * Método que exclui dados no sistema de persistencia
     * @param $id int identificador do registro 
     * @return void
     */
    function excluir($id)
    {
        try {      
            $this->conn = new PDO('sqlite:' . __DIR__ . '/pessoas.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->conn->prepare('DELETE FROM pessoa WHERE id=:id');
            $stmt->execute(
                array(
                    ':id' => $id
                )
            );
            print $stmt->rowCount();
        } catch (PDOException $e) {
            print 'Error: ' . $e->getMessage();
        }

    }
    /*
     * Método que lista dados no sistema de persistencia
     * @return array array de dados
     */
    function listar()
    {
        $dados = array();
        try {
            $this->conn = new PDO('sqlite:' . __DIR__ . '/pessoas.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $result = $this->conn->query("SELECT * FROM pessoa");

            while ($linha = $result->fetch(PDO::FETCH_ASSOC)) {
                $pessoa = array();
                $pessoa['id'] = $linha['id'];
                $pessoa['nome'] = $linha['nome'];
                $pessoa['altura'] = $linha['altura'];
                $pessoa['peso'] = $linha['peso'];
                $pessoa['email'] = $linha['email'];
                $pessoa['cidade'] = $linha['cidade'];
                array_push($dados, $pessoa);
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        return $dados;

    }
    /* Método que lista dados com filtro no sistema de persistencia
     * @param $filtro String filtro para dados     
     * @return array array de dados
     */
    function listar_filtro($filtro)
    {
        $dados = array();
        try {
            $this->conn = new PDO('sqlite:' . __DIR__ . '/pessoas.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $result = $this->conn->query("SELECT * FROM pessoa " . $filtro);

            while ($linha = $result->fetch(PDO::FETCH_ASSOC)) {
                $pessoa = array();
                $pessoa['id'] = $linha['id'];
                $pessoa['nome'] = $linha['nome'];
                $pessoa['altura'] = $linha['altura'];
                $pessoa['peso'] = $linha['peso'];
                $pessoa['email'] = $linha['email'];
                $pessoa['cidade'] = $linha['cidade'];
                array_push($dados, $pessoa);
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }


        return $dados;

    }
    /*
     * Método que obtem dados no sistema de persistencia
     * @param $id int identificador do registro 
     * @return array objeto em array
     */
    function obter($id)
    {
        $pessoa = array();
        try {
            $this->conn = new PDO('sqlite:' . __DIR__ . '/pessoas.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $result = $this->conn->prepare("SELECT * FROM pessoa WHERE id=:id");
            $result->execute(array(':id' => $id));

            if ($linha = $result->fetch(PDO::FETCH_ASSOC)) {
                $pessoa['id'] = $linha['id'];
                $pessoa['nome'] = $linha['nome'];
                $pessoa['altura'] = $linha['altura'];
                $pessoa['peso'] = $linha['peso'];
                $pessoa['email'] = $linha['email'];
                $pessoa['cidade'] = $linha['cidade'];
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        return $pessoa;
    }
}
?>