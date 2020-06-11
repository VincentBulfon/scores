<?php


namespace Models;


class Model
{
    protected $pdo = null;
    protected $table;
    protected $findKey;
    protected $order;

    public function __construct()
    {
        try {
            //génère une connextion à la base de données
            $connection = new \PDO('sqlite:' . DB_PATH);
            //mode de gestion des erreurs de pdo attribut et sa valeur, cela peut être aussi défini sur une seule ligne à la création du DPO, le mode d'erreur EXCEPEITON nous renvoi un objet exeption et une message
            $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        $this->pdo = $connection;
    }

    public function find(string $key): \stdClass
    {
        $request = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->findKey . ' = :' . $this->findKey;
        $pdoSt = $this->pdo->prepare($request);
        $pdoSt->execute([':' . $this->findKey => $key]);

        return $pdoSt->fetch();
    }

    public function all()
    {
        $request = 'SELECT * FROM ' . $this->table . ' ORDER BY ' .$this->order;
        $pdoSt = $this->pdo->query($request);

        return $pdoSt->fetchAll();
    }
}