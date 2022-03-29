<?php

// Criacao de um array para erros!
$erro = $config = array();

// Prepara a variavel do arquivo
$arquivo = isset($_FILES["logo"]) ? $_FILES["logo"] : FALSE;		   

// Tamanho maximo do arquivo (em bytes)
$config["tamanho"] = 200000;

// Largura maxima (pixels)
$config["largura"] = 640;

// Altura maxima (pixels)
$config["altura"]  = 640;

// Formulario postado... executa as acoes
if(getimagesize($_FILES["logo"]["tmp_name"])==true)
{  
    // Verifica se o mime-type do arquivo de imagem
    if($arquivo["type"]!=("jpeg"||"jpg"||"gif"||"png"))
    {
      $erro[] = "Somenete arquivos jpg, jpeg, bmp, gif ou png.!!!";
    }
    else
    {
        // Verifica tamanho do arquivo
        if($arquivo["size"] > $config["tamanho"])
        {
            $erro[] = "Tamanho maximo " . $config["tamanho"] . " bytes(200K)!!!'";
        }

        // Para verificar as dimensaes da imagem
        $tamanhos = getimagesize($arquivo["tmp_name"]);

        // Verifica largura
        if($tamanhos[0] > $config["largura"])
        {
          $erro[] = "Largura Maxima " . $config["largura"] . " pixels!!!";
        }

        // Verifica altura
        if($tamanhos[1] > $config["altura"])
        {
          $erro[] = "Altura Maxima " . $config["altura"] . " pixels!!!'";
        }
    }

    
$msg = "";
    // Imprime as mensagens de erro através de um array criado
    if(sizeof($erro))
    {
        foreach($erro as $err)
        {
            $msg = $msg." - " . $err."<br/>";
        }echo $msg."<a href='index.php'><input type='submit' value='Voltar' name='submit'></a>";
    }
    
    // Verificacao de dados
    // Nenhum erro, executa entao o upload...
    else
    {
      // Pega extensao do arquivo
      preg_match("/.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);

      // Gera um nome unico para a imagem atraves de um HASH de criptografia em MD% e o time do servidor
      $imagem_nome =       md5(uniqid(time())) . "." . $ext[1];

      // Caminho de onde a imagem ficar
      $imagem_dir = "uploads/" . $imagem_nome;

      // Faz o upload da imagem
      move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
	  
      echo "<script>alert('Arquivo Salvo com sucesso!!');history.back();</script>";
    }
  } else {
    echo "<script>alert('Arquivo Invalido!!');history.back();</script>";
  }
?>
