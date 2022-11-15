<?php

use Phalcon\Http\Request;

class NoticiaController extends ControllerBase
{
    private $mensagemDeErro = '';

    public function listaAction()
    {
        $noticias = Noticia::find();

        $this->view->noticias = $noticias;

        $this->view->pick("noticia/listar");
    }

    public function cadastrarAction()
    {   
        $id = $this->request->getPost('id');
        $titulo = $this->request->getPost('titulo');
        $texto = $this->request->getPost('texto');

        if(EMPTY($titulo)) {
            $this->flash->error('Título é obrigatório');
            return $this->response->redirect(['for' => 'noticia.cadastrar']);
        }

        if(strlen($titulo) > 255) {
            $this->flash->error('Título não pode exceder 255 caracteres');
            return $this->response->redirect(['for' => 'noticia.cadastrar']); 
        }

        $noticia = Noticia::findFirst(
            Array(
                "id = :id:",
                    'bind' => array(
                        'id'    => $id
                    )
            )
        );

        if(!EMPTY($noticia)) {
            $noticia->save(
                [
                    "titulo" => $titulo,
                    "texto" => $texto,
                    "data_ultima_atualizacao" => date_create('now')->format('Y-m-d H:i:s')
                ]
            );
            $this->flash->success('Notícia alterada com sucesso');
            return $this->response->redirect(array('for' => 'noticia.lista'));
        }
    }

    public function salvarAction()
    {
        $titulo = $this->request->getPost('titulo');
        $texto = $this->request->getPost('texto');

        if(EMPTY($titulo)) {
            $this->flash->error('Título é obrigatório');
            return $this->response->redirect(['for' => 'noticia.cadastrar']);
        }

        if(strlen($titulo) > 255) {
            $this->flash->error('Título não pode exceder 255 caracteres');
            return $this->response->redirect(['for' => 'noticia.cadastrar']); 
        }

        $noticia = Noticia::findFirst(
            Array(
                "titulo = :titulo:",
                    'bind' => array(
                        'titulo'    => $titulo
                    )
            )
        );

        if($noticia == false ) {
            $newNoticia = new Noticia();
        
            $newNoticia->save([
                "titulo" => $titulo,
                "texto" => $texto,
                "data_ultima_atualizacao" => date_create('now')->format('Y-m-d H:i:s'),
                "data_cadastro" => date_create('now')->format('Y-m-d H:i:s')
            ]);

            return $this->response->redirect(array('for' => 'noticia.lista'));
        }

        $this->flash->error('Notícia já criada');
        return $this->response->redirect(['for' => 'noticia.cadastrar']);
    }

    public function editarAction($id)
    {   
        $noticia = Noticia::findFirst($id);

        if(EMPTY($noticia)) {
            $this->flash->error('Notícia não existe');
            return $this->response->redirect(['for' => 'noticia.lista']);
        }

        $this->view->noticia = $noticia;
        $this->view->pick("noticia/editar");
    }

    

     public function excluirAction($id)
     {
        $noticia = Noticia::findFirst($id);

        if ($noticia !== false) {
            if ($noticia->delete() === false) {
                $this->flash->success('Notícia não poude ser excluída');
            } else {
                $this->flash->success('Notícia excluída com sucesso');
                return $this->response->redirect(array('for' => 'noticia.lista'));
            }
        }
     }

}