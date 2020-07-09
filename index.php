<?php

	header('Content-Type: text/html; charset=utf-8');

	require_once 'vendor/autoload.php';
	// use DOMWrap\Document;

	/*/ ======================================================================
		Multi-Environment Twig Loader
	====================================================================== /*/

	$env = "live";
	$host = $_SERVER["HTTP_HOST"];

	$settings = [
		'cache' => false,
		'debug' => true
	];

	$loader = new \Twig\Loader\FilesystemLoader('./');
	$twig = new \Twig\Environment($loader, $settings);


	/*/ ======================================================================
		Load Site and Data
	====================================================================== /*/

	$pathname = $_GET['p'] ?? 'index';
	$slug = basename($pathname);

	$data = [
		'ip' => $_SERVER["REMOTE_ADDR"],
		'env' => $env,
		'url' => $_SERVER["HTTP_HOST"],
		'query' => $_GET,
		'slug' => $slug,
		'pathname' => $pathname,
		'site' => [
			'name' => 'MWG Email System',
			'gtag' => '',
			'designer' => [
				'contributors' => 'Stephen Ginn',
				'company' => 'Crema Design Studio',
				'url' => 'https://cremadesignstudio.com'
			]
	    ],
		'company' => [
			'name' => 'Crema Design Studio',
			'street' => '1107 Highland Colony Parkway, Suite 205',
			'city' => 'Ridgeland',
			'state' => 'MS',
			'zip' => '39157'
		]
	];


	/*/ ======================================================================
		Render Pages
	====================================================================== /*/

	$home = `printf ~`;
	putenv("HOME=$home");
	putenv('PATH=$PATH:/bin:/usr/bin:/usr/local/bin:$HOME/bin');

	try {
		// Render MJML Template
		// $src = $twig->render("src/templates/promotional.html");
		$src = file_get_contents('./src/templates/promotional.html');
		$src = str_replace('"', '\"', $src);
		$html = shell_exec('. ~/.bashrc; node index.js ' . '"' . $src . '"');

		echo $html;
	} catch (Exception $e) {
		echo $twig->render('404.twig', $data);
	}

?>
