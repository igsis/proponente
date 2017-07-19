<?php
$con = bancoMysqli();
$idPessoaJuridica = $_SESSION['idUsuario'];

$pj = recuperaDados("usuario_pj","id",$idPessoaJuridica);

$busca = $_POST['busca'];
$sql_busca = "SELECT * FROM representante_legal WHERE cpf = '$busca' ORDER BY nome";
$query_busca = mysqli_query($con,$sql_busca); 
$num_busca = mysqli_num_rows($query_busca);

if($num_busca > 0)
{ // Se exisitr, lista a resposta.
?>
	<section id="list_items" class="home-section bg-white">
		<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
			<div class="form-group">
				<h3>REPRESENTANTE LEGAL #2</h3>
				<p><b>Código de cadastro:</b> <?php echo $idPessoaJuridica; ?> | <b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
				<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<div class="table-responsive list_info">
						<table class="table table-condensed">
							<thead>
								<tr class="list_menu">
									<td>Nome</td>
									<td>CPF</td>
									<td width="15%"></td>
								</tr>
							</thead>
							<tbody>
							<?php
								while($descricao = mysqli_fetch_array($query_busca))
								{			
									echo "
										<tr>
											<td class='list_description'><b>".$descricao['nome']."</b></td>
											<td class='list_description'>".$descricao['cpf']."</td><td class='list_description'>
											<form method='POST' action='?perfil=representante2_pj_cadastro&id_pj=".$idPessoaJuridica."'>
												<input type='hidden' name='insereRepresentante' value='".$descricao['id']."'>
												<input type ='submit' class='btn btn-theme btn-md btn-block' value='escolher'>
											</form>
											</td>
										</tr>
									";
								}
							?>
							</tbody>
						</table>
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<a href="?perfil=representante2_pj"><input type="submit" value="Inserir outro representante" class="btn btn-theme btn-block"></a> 
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</section>  

<?php
}
else
{ // se não existir o cpf, imprime um formulário.
?>	
	<section id="contact" class="home-section bg-white">
		<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
			<div class="form-group">
				<h3>INFORMAÇÕES INICIAIS</h3>
				<p><b>Código de cadastro:</b> <?php echo $idPessoaJuridica; ?> | <b>Razão Social:</b> <?php echo $pj['razaoSocial']; ?></p>
				<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=representante2_pj_cadastro" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
							<input type="text" class="form-control" name="nome" placeholder="Nome completo">
						</div>
					</div>
					  
					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>RG: *</strong><br/>
							<input type="text" class="form-control" name="rg" placeholder="RG">
						</div>
						<div class="col-md-6"><strong>CPF: *</strong><br/>
							<input type="text" readonly class="form-control" name="cpf" value="<?php echo $busca ?>" placeholder="CPF">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Nacionalidade: </strong><br/>
							<input type="text" class="form-control" name="nacionalidade" placeholder="Nacionalidade">
						</div>
						<div class="col-md-6"><strong>Estado civil:</strong><br/>
							<select class="form-control" name="idEstadoCivil" >
								<?php geraOpcao("estado_civil","",""); ?>  
							</select>
						</div>	
					</div>	  
			  
						  
					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="cadastraRepresentante">
							<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>
				
				</div>
			</div>
		</div>
	</section>  
<?php	
}
?>
