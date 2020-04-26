<?php	
				require_once '_app/config.php';

				$Login = $fb->getRedirectLoginHelper();
				$permissions = ['email'];

				use Facebook\GraphUser;

				try{
					if(isset($_SESSION['facebook_access_token'])){
						$accessToken = $_SESSION['facebook_access_token'];
					}else{
						$accessToken = $Login->getAccessToken();
					}
				}catch (Facebook\Exceptions\FacebookResponseException $e){
					// Graph retorna um erro
					echo 'Graph returned an error: ' . $e->getMessage();
					exit;
				}catch (Facebook\Exceptions\FacebookSDKException $e){
					// Falha de validação ou problemas locais
					echo 'Facebook SDK returned an error: ' . $e->getMessage();
					exit;
				}
				if(isset($accessToken)){
					if(isset($_SESSION['facebook_access_token'])){
						$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
					}else{
						$_SESSION['facebook_access_token'] = (string) $accessToken;
						$oAutr2Client = $fb->getOAutr2Client();
						$longLivedAccessToken = $oAutr2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
						$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
						$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
					}
					if(isset($_GET['code'])){
						header('Location: ./');
					}
					try{
						$profile_request = $fb->get('/me?fields=name,first_name,last_name,email, short_name');
						$profile = $profile_request->getGraphNode()->asArray();
						echo '<h3 style="text-align: center">Olá '.$profile['name']. ', sejá bem vindo! </h3>';	
					}catch (Facebook\Exceptions\FacebookResponseException $e){
						echo 'Graph returned an error: ' . $e->getMessage();
						session_destroy();
						header("Location: ./");
						exit;
					}catch (Facebook\Exceptions\FacebookSDKException $e){
						echo 'Facebook SDK returned an error: ' . $e->getMessage();
						exit;
					}
				}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dr Jhonnys</title>
    <meta name="Description" content="Klinik is a HTML5 & CSS3 responsive template">
    <link rel="icon" type="image/x-icon" href="a/images/favicon.png" />
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Montserrat:400,500">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/material.min.css" />
    <link rel="stylesheet" href="css/mdl-selectfield.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" />
    <link rel="stylesheet" href="css/animate.min.css" />
    <link rel="stylesheet" href="css/magnific-popup.css" />
    <link rel="stylesheet" href="css/flexslider.css" />
    <!-- Custom Main Stylesheet CSS -->
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/flex.css">
	<link rel="stylesheet" href="freebie-footer-templates\css\footer-distributed-with-address-and-phones.css">
	
	<header id="header-3" class="">
        <div class="hdr-center-menu">
            <div class="hdr layer-stretch">
                <div class="row align-items-center justify-content-end">
                    <ul class="col menu text-left m-0 p-0">
                        <li><a id="menu-home" href ="#sobre" class="mdl-button mdl-js-button mdl-js-ripple-effect">Sobre</a></li>
                        <li><a id="menu-doctor" href="#tratamento" class="mdl-button mdl-js-button mdl-js-ripple-effect">Métodos de Tratamentos</a></li>
                        <li><a href="#footer1" id="menu-shortcodes" class="mdl-button mdl-js-button mdl-js-ripple-effect">Contatos</a></li>
						<li><a href="http://localhost:70/Trabalho/dados.php" id="menu-shortcodes" class="mdl-button mdl-js-button mdl-js-ripple-effect">Dados do Usuário</a></li>
						<li><?php
							require_once '_app/config.php';
							$logoff = filter_input(INPUT_GET, 'sair', FILTER_DEFAULT);
								if(isset($logoff) && $logoff == 'true'):
									session_destroy();
									header("Location: index.php");
								endif;
								echo '<a href="?sair=true">Sair</a>'
						?></li>
                    </ul>
                </div>
            </div>
        </div>
    </header><br><br><br>
		<!--Inicio Sobre-->
		<section id="sobre">
			<div id="hm-service" class="layer-stretch">
				<div class="layer-wrapper">
					<div class="layer-ttl">
						<h3>Dr Jhonnys Lakers</h3>
					</div>
					<div class="inner flex flex-3">
						<div class="flex-item left">
						<div>
							<h3 style="color: #7674e3;">Formação Acadêmica</h3>
							<p align="center">Medicina<br> Universidade Federal de Juiz de Fora (UFJF)<br>
								Ano de Conclusão: 1985</p>
						</div><br><br><br>
						<div>
							<h3 style="color: #7674e3;">Área de Especialidade</h3>
							<p align="center">Ortopedista Infantil<br> 
							Ano de Conclusão: 1988 </p>
						</div>
					</div>

					<div class="image left">
						<img src="images/medico.jpg" alt="" />
					</div>

					<div class="flex-item right">
						<div>
							<h3 style="color: #7674e3;">Especialização</h3>
							<p align="justify">UFMG e Hospital da Baleia<br>
								Belo Horizonte-MG<br>Bloqueios Químicos UNIFEST-SP<br>
								Membro SBOT</p>
						</div><br><br>

						<div>
							<h3 style="color: #7674e3;">Ênfase</h3>
							<p align="justify">Tratamento do pé torto congênito pelo método de Ponseti,<br> 
							Especialista em bloqueios químicos com toxina botulinica para adultos e crianças,<br>
							Distúrbios neuromusculares.</p>
						</div>
					</div>
				</div>
			</div>
		</section>
	<!--Fim Sobre-->
	<!--Inicio Tratamento-->
		<section id="tratamento">
			<div id="slider" class="slider-height">
				<div class="flexslider slider-wrapper">
					<ul class="slides">
						<li>
							<div class="slider-info">
								<h1 class="animated fadeInDown">Método de Ponseti</h1>
								<p class="animated fadeInDown">É o método que traz melhores resultados na abordagem do pé torto congênito idiopático. O DrJhonnys Lakers possui experiência de mais de 15 anos na técnica, com bons resultados funcionais. Procure o ortopedista infantil o mais precocemente possível.</p>
							</div>
							<img src="images/fundo.png" alt="" />
						</li>
						<li>
							<div class="slider-info">
								<h2>Bloqueios Quimicos com Toxina Botulinica</h2>
								<p>A toxina do bem! Seu uso terapêutico controla de maneira temporaria a espasticidade, a hipertonia e a distonia, melhorando a reabilitação e a qualidade de vida dos pacientes portadores de paralisia cerebral espastica, distonias e sequelas de enfermidades neuromusculares.</p>
							</div>
							<img src="images/fundo.png" alt="" />
						</li>
						<li>
							<div class="slider-info">
								<h2>Disturbios Neuromusculares</h2>
								<p>Abrange um universo alargado de diferentes patologias. O ortopedista atua como um dos especialistas multidisciplinares necessários.</p>
							</div>
							<img src="images/fundo.png" alt="" />
						</li>
					</ul>
					
				</div>
			</div>
		</section>
		
  </head>
  <body>
    
    <!-- Start Footer Section -->
    <footer class="footer-distributed" id="footer1">

			<div class="footer-left">
			<h3>Dr<span> Jhonnys Lakers</span></h3>
			</div>

			<div class="footer-center">

				<div>
					<i class="fa fa-map-marker"></i>
					<p><span>Praça Menelick de Carvalho, 50 <br> Santa Helena</span>Juiz de Fora-MG</p>
				</div>

				<div>
					<i class="fa fa-phone"></i>
					<p><a href="tel:3232270777">(32) 3227-0777 </a>|<a href="tel:3232277666"> (32) 3227-7666</a></p>
				</div>

				<div>
					<i class="fa fa-envelope"></i>
					<p><a href="mailto:jhonnys.terra81@gmail.com">jhonnys.terra81@gmail.com</a></p>
				</div>

			</div>

			<div class="footer-right">
				<div class="footer-icons">
					<a href="#"><i class="fa fa-facebook"></i></a>
					<a href="#"><i class="fa fa-instagram"></i></a>
				</div>

			</div>

		</footer>
	
    <!-- **********Included Scripts*********** -->

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/material.min.js"></script>
    <script src="js/mdl-selectfield.min.js"></script>
    <script src="js/jquery.flexslider.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery-scrolltofixed.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.counterup.js"></script>
    <script src="js/smoothscroll.min.js"></script>
    <script src="js/custom.js"></script>
    
</body>
</html>