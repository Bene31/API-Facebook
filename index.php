		<?php

		require_once '_app/config.php';

		$Login = $fb->getRedirectLoginHelper();
		$permissions = ['email'];

		use Facebook\GraphUser;
		echo '<link rel=”stylesheet” type=”text/css” href=css/css.css” />';

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
				$oAuth2Client = $fb->getOAuth2Client();
				$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
				$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
				$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
			}
			if(isset($_GET['code'])){
				header('Location: ./');
			}
			try{
				$profile_request = $fb->get('/me?fields=name,first_name,last_name,email,picture');
				$profile = $profile_request->getGraphNode()->asArray();
				
				//echo '<script type=\'text/javascript\'>alert("Olá '.$profile['name']. ', seja bem vindo!");</script>';
				header("Location: main.php");
				echo '<h2 style="text-align: center">Olá '.$profile['name']. ', sejá bem vindo! </h2>';	
				//echo '<img src="{$profile["cover"]["source"]}">';
				echo '<p style="text-align: center"><a href="http://localhost:70/Trabalho/main.php">Ir para o site</a></p>';
			}catch (Facebook\Exceptions\FacebookResponseException $e){
				echo 'Graph returned an error: ' . $e->getMessage();
				session_destroy();
				header("Location: ./");
				exit;
			}catch (Facebook\Exceptions\FacebookSDKException $e){
				echo 'Facebook SDK returned an error: ' . $e->getMessage();
				exit;
			}
			$logoff = filter_input(INPUT_GET, 'sair', FILTER_DEFAULT);
			if(isset($logoff) && $logoff == 'true'):
				session_destroy();
				header("Location: ./");
			endif;
			//echo '<br><a href="?sair=true">Sair</a><br>';
		}else{
			$loginUrl = $Login->getLoginUrl('http://localhost:70/Trabalho/index.php', $permissions);
			echo '<link rel="stylesheet" href="css/css.css">
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
				
				<div class="container">	
					<form action="/action_page.php">
						<div class="row">
						  <h1 style="text-align:center">Login</h1>
						  <div class="vl">
							<span class="vl-innertext"></span>
						  </div>

						  <div class="col">
							<a href="' . $loginUrl . '" class="fb btn">
							  <i class="fa fa-facebook fa-fw"></i> Entrar com Facebook
							</a>
						  </div>

						  <div class="col">
							<div class="hide-md-lg">
							  <p>Or sign in manually:</p>
							</div>

							<input type="text" name="username" placeholder="Usuario" required>
							<input type="password" name="password" placeholder="Senha" required>
							<input type="submit" value="Login">
						  </div>
						</div>
					</form>
				</div>

				<div class="bottom-container">
				  <div class="row">
					<div class="col">
					  <a href="#" style="color:white" class="btn">Cadastrar</a>
					</div>
					<div class="col">
					  <a href="#" style="color:white" class="btn">Esqueceu sua senha?</a>
					</div>
				  </div>
				</div>';
			
			echo $accessToken;
		}
