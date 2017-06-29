<?php
$con = bancoMysqli();
$idPessoaJuridica = $_SESSION['idUsuario'];

$pj = recuperaDados("usuario_pj","id",$idPessoaJuridica);

if ($pj['idRepresentanteLegal1'] == 0) // Não possui representante legal cadastrado
{	
?>	
	<section id="services" class="home-section bg-white">
		<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
						<h3>REPRESENTANTE LEGAL</h3>
						<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
						<p><strong>Você está inserindo representante legal </strong></p>
						<p></p>
					</div>
				</div>
			</div>
			<div class="row">
				<form method="POST" action="?perfil=representante1_pj_resultado_busca" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">				      
							<label>Insira o CPF</label>
								<input type="text" name="busca" class="form-control" id="cpf" >
						</div>
					</div>
					
					<br />             
				 
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Pesquisar">                   
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
		
<?php	
}	
else
{
	echo "<br><br><br><br>".$pj['idRepresentanteLegal1'];
}	
?>