<?php

use Phalcon\Mvc\Model;
use Phalcon\Paginator\Adapter\Model as Paginator;

class Categoria extends Model {
  private $id;
  private $nome;
  private $noticia_id;

  public function initialize() {
    
    $this->setSource("categoria");

    $this->hasMany(
        'id',
        'NoticiaCategoria',
        'id_categoria'
    );

  }

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  { 
    $this->id = $id;
  }

  public function getNome() {
    return $this->$nome;
  }

  public function setNome($nome) {
    $this->nome = $nome;
  }
}