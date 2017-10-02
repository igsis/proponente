<?php
$con = bancoMysqli();
$idPessoaFisica = $_SESSION['idUser'];

$idCampo = 30;
$tipoPessoa = 1;

if(isset($_POST['cadastrarFisica']))
{
	$idPessoaFisica = $_POST['cadastrarFisica'];
	$Drt = $_POST['drt'];
	$CBO = $_POST['cbo'];
	$Funcao = $_POST['funcao'];
	$Omb = $_POST['omb'];
	
	$sql_atualiza_complementares = "UPDATE usuario_pf SET
	`drt` = '$Drt',
	`cbo` = '$CBO',
	`funcao` = '$Funcao',
	`omb` = '$Omb'
	WHERE `id` = '$idPessoaFisica'";
	
	
	if (mysqli_query($con,$sql_atualiza_complementares))
	{
		$mensagem = "Atualizado com sucesso!";	
	}
	else
	{
		$mensagem = "Erro ao atualizar! Tente novamente.";
	}	
}


if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id = '$idCampo'";
	$query_arquivos = mysqli_query($con,$sql_arquivos);
	while($arq = mysqli_fetch_array($query_arquivos))
	{ 
		$y = $arq['id'];
		$x = $arq['sigla'];
		$nome_arquivo = $_FILES['arquivo']['name'][$x];
		$f_size = $_FILES['arquivo']['size'][$x];
		
		//Extensões permitidas
		$ext = array("PDF","pdf");
		
		if($f_size > 2097152) // 2MB em bytes
		{
			$mensagem = "Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 02 MB.";
		}
		else
		{		
			if($nome_arquivo != "")
			{
				$nome_temporario = $_FILES['arquivo']['tmp_name'][$x];		
				$new_name = date("YmdHis")."_".semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
				$hoje = date("Y-m-d H:i:s");
				$dir = '../uploadsdocs/'; //Diretório para uploads
				
				$allowedExts = array(".pdf", ".PDF"); //Extensões permitidas
				
				$ext = strtolower(substr($nome_arquivo,-4));

				if(in_array($ext, $allowedExts)) //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas
				{			
			
					if(move_uploaded_file($nome_temporario, $dir.$new_name))
					{  
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPessoaFisica', '$y', '$new_name', '$hoje', '1'); ";
						$query = mysqli_query($con,$sql_insere_arquivo);
					
						if($query)
						{
							$mensagem = "Arquivo recebido com sucesso!";
						}
						else
						{
							$mensagem = "Erro ao gravar no banco!";
						}
					}
					else
					{
						$mensagem = "Erro no upload. Tente novamente!"; 
					}
				}
				else
				{
					$mensagem = "Erro no upload! Anexar documentos somente no formato PDF."; 
				}
			}	
		}
	}
}

if(isset($_POST['apagar']))
{
	$idArquivo = $_POST['apagar'];
	$sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE id = '$idArquivo'";
	if(mysqli_query($con,$sql_apagar_arquivo))
	{
		$mensagem =	"Arquivo apagado com sucesso!";
		gravarLog($sql_apagar_arquivo);
	}
	else
	{
		$mensagem = "Erro ao apagar o arquivo. Tente novamente!";
	}
}



$pf = recuperaDados("usuario_pf","id",$idPessoaFisica);

?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h3>INFORMAÇÕES COMPLEMENTARES</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaFisica; ?> | <b>Nome:</b> <?php echo $pf['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=informacoes_complementares_pf" method="post">
					  
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>DRT:</strong><br/>
							<input type="text" class="form-control" name="drt" placeholder="DRT" value="<?php echo $pf['drt']; ?>">
						</div>
					</div>		
		 
					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>C.B.O.:</strong> <i><a href="http://www.mtecbo.gov.br/cbosite/pages/pesquisas/BuscaPorTitulo.jsf" target="_blank">Consulte o código aqui</a></i><br/>
							<input type="text" class="form-control" id="cbo" name="cbo" placeholder="C.B.O."value="<?php echo $pf['cbo']; ?>" >
						</div> 				  
						<div class="col-md-6"><strong>Função:</strong><br/>
							<input type="text" class="form-control" id="Funcao" name="funcao" placeholder="Função" value="<?php echo $pf['funcao']; ?>">
						</div>
					</div>	

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>O.M.B.:</strong><br/>
							<input type="text" class="form-control" id="omb" name="omb" placeholder="O.M.B." value="<?php echo $pf['omb']; ?>">
						</div> 				 
					</div>					
			  
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="cadastrarFisica" value="<?php echo $idPessoaFisica ?>">	<input type="hidden" name="Sucesso" id="Sucesso" />
							<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>
				
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>
				
				<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
							<?php listaArquivoCamposMultiplos($idPessoaFisica,$tipoPessoa,$idCampo,"dados_bancarios_pf",3); ?>
						</div>
					</div>
				</div>	
				
						<div class="form-group">
			<div class="col-md-offset-2 col-md-8">
				<div class = "center">
				<form method="POST" action="?perfil=informacoes_complementares_pf" enctype="multipart/form-data">
					<table>
						<tr>
							<td width="45%"><td>
						</tr>
						<?php 
							$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id = '$idCampo'";
							$query_arquivos = mysqli_query($con,$sql_arquivos);
							while($arq = mysqli_fetch_array($query_arquivos))
							{ 
						?>
								<tr>
									<td><label><?php echo $arq['documento']?></label></td>
									<td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
								</tr>
						<?php 
							}
						?>
					</table><br>
				
					<input type="hidden" name="idPessoa" value="<?php echo $idPessoaFisica; ?>"  />
					<input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"  />
					<input type="hidden" name="enviar" value="1"  />
					<input type="submit" class="btn btn-theme btn-lg btn-block" value='Enviar'>
				</form>
				</div>
			</div>
		</div>
		
		<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
		</div>
		
				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">					
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=endereco_pf" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaFisica ?>">
						</form>	
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=dados_bancarios_pf" method="post">	
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaFisica ?>">
						</form>	
					</div>					
				</div>
				
			</div>
		</div>
	</div>
</section>  