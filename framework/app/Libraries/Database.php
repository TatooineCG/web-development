<?php

class Database {

    private $host = 'localhost';
    private $usuario = 'root';
    private $senha = '';
    private $banco = 'framework';
    private $porta = '3306';
    private $dbh;
    private $stmt;

    // FUNÇÃO CONSTRUCT
    public function __construct() {
        $dsn = 'mysql:host='.$this->host.';port='.$this->porta.';dbname='.$this->banco;

        $opcoes = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->dbh = new PDO($dsn, $this->usuario, $this->senha, $opcoes);

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    // FUNÇÃO QUERY
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // FUNÇÃO BIND
    public function bind($parametro, $valor, $tipo = null) {
        if(is_null($tipo)):
            switch(true):
                case is_int(($valor)):
                    $tipo = PDO::PARAM_INT;
                break;

                case is_bool($valor):
                    $tipo = PDO::PARAM_BOOL;
                break;

                case is_null($valor):
                    $tipo = PDO::PARAM_NULL;
                break;

                default:
                    $tipo = PDO::PARAM_STR; 

            endswitch;

        endif;

        $this->stmt->bindValue($parametro, $valor, $tipo);

           }

        // FUNÇÃO EXECUTA
        public function executa() {
            return $this->stmt->execute();
        }

        // FUNÇÃO RESULTADO
        public function resultado() {
            $this->executa();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        // FUNÇÃO RESULTADOS
        public function resultados() {
            $this->executa();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // FUNÇÃO TOTAL DE RESULTADOS
        public function totalResultados() {
            return $this->stmt->rowCount();
        }

        // FUNÇÃO ÚLTIMO ID INSERIDO
        public function ultimoIdInserido() {
            return $this->stmt->lastInsertId();
        }
    }
?>