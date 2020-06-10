<?php


namespace Models;


class Model
{
    protected $pdo = null;

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
}