<?php

use Phalcon\Mvc\Model;

class NoticiaCategoria extends Model 
{
  public $id;
  public $id_noticia;
  public $id_categoria;

  public function initialize(){
    $this->belongsTo(
      'id_noticia',
      'Noticia',
      'id'
    );

    $this->belongsTo(
      'id_categoria',
      'Categoria',
      'id'
    );
  }
}