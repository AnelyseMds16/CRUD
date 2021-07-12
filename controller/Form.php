<?php
class Form
{
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    $form = new Template("view/form.html");
    $retorno["msg"] = $form->saida();
    return $retorno;
  }

  public function salvar()
  {
    if (isset($_POST["titulo"]) && isset($_POST["autor"]) && isset($_POST["resenha"])) {
      try {
        $conexao = Transaction::get();
        $titulo = $conexao->quote($_POST["titulo"]);
        $autor = $conexao->quote($_POST["autor"]);
        $resenha = $conexao->quote($_POST["resenha"]);
        $crud = new Crud();
        $retorno = $crud->insert(
          "livro",
          "titulo,autor,resenha",
          "{$titulo},{$autor},{$resenha}"
        );
      } catch (Exception $e) {
        $retorno["msg"] = "Ocorreu um erro! " . $e->getMessage();
        $retorno["erro"] = TRUE;
      }
    } else {
      $retorno["msg"] = "Preencha todos os campos! ";
      $retorno["erro"] = TRUE;
    }
    return $retorno;
  }

  public function __destruct()
  {
    Transaction::close();
  }
}