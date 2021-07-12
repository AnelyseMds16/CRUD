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
    if (isset($_POST["equipe"]) && isset($_POST["piloto"]) && isset($_POST["posicao"])) {
      try {
        $conexao = Transaction::get();
        $equipe = $conexao->quote($_POST["equipe"]);
        $piloto = $conexao->quote($_POST["piloto"]);
        $posicao = $conexao->quote($_POST["posicao"]);
        $crud = new Crud();
        $retorno = $crud->insert(
          "corrida",
          "equipe, piloto, posicao",
          "{$equipe},{$piloto},{$posicao}"
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