<?php

if(isset($_GET['p']))
{
	$p = $_GET['p'];
}
else
{
	$p = 'lista';	
}

switch($p)
{	
	case 'erro_representante1':
?>
		<section id="list_items" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">
						<div class="section-heading">
							<h4><font color='red'>CPF inválido! por favor, insira o número correto!</font></h4> 
							<h4><font color='red'>Redirecionando...</font></h4>
							<p></p>
						</div>
					</div>
				</div>			
			</div>
		</section>
	<?php 
		echo "<meta HTTP-EQUIV='refresh' CONTENT='3.5;URL=?perfil=representante1_pj'>"; 
	break;
	
	case 'erro_representante2':
		$id_ped = $_GET['id_ped'];
	?>
		<section id="list_items" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">
						<div class="section-heading">
							<h4><font color='red'>CPF inválido! por favor, insira o número correto!</font></h4> 
							<h4><font color='red'>Redirecionando...</font></h4>
							<p></p>
						</div>
					</div>
				</div>			
			</div>
		</section>
	<?php 
		echo "<meta HTTP-EQUIV='refresh' CONTENT='3.5;URL=?perfil=representante2_pj'>";
	break;
} //fim da switch
?>