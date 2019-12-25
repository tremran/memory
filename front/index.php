<?php 

/*
Ce fichier sert :
 - de routeur (il connait les URI du site )
 - de controlleur (il connait la logique du jeu).

Dans projet plus volumineux, il est conseillé de séparer ces deux fonctions 
*/


include __DIR__ . '/../src/include.php'; 

use Memoire\MemoireGame;

$request = $_SERVER['REQUEST_URI'];
$request = explode('?', $request)[0];

$dossier_front = ['css' => 'text/css', 'img' => null, 'js' => 'text/javascript'];

$estRessource = false;
$finalTypeMime = null;
foreach ($dossier_front as $folder => $typeMime)
{
	if (substr($request, 1, strlen($folder)) == $folder)
	{
		$estRessource = true;
		if (! is_null($typeMime))
		{
			$finalTypeMime = $typeMime;
		}
	}
}

if (! $estRessource) 
{ // on ne demande pas une ressource js, css ou image, donc on affiche une page
	switch ($request) {
		case '' :
		case '/' :
			// récupère les meilleurs score
			$dqlQuery = 'Select g FROM Memoire\MemoireGame g where g.pairCount = :pair_count AND g.time IS NOT NULL ORDER BY g.time ASC';
			$query = $entityManager->createQuery($dqlQuery);
			$query->setParameter('pair_count', $config['nb_paires']);
			$query->setMaxResults(10);
var_dump($query->getSQL());
			$gameList = $query->getResult();

			include __DIR__ . '/../src/vues/_header.php';
			require __DIR__ . '/../src/vues/home.php';
			include __DIR__ . '/../src/vues/_footer.php';
			break;
		case '/game' :
			$gameId = uniqid();
			// crée une nouvelle partie
			$game = new MemoireGame($gameId, $config['nb_paires']);
			$entityManager->persist($game);
			$entityManager->flush();

			include __DIR__ . '/../src/vues/_header.php';
			require __DIR__ . '/../src/vues/game.php';
			include __DIR__ . '/../src/vues/_footer.php';

			break;
				
		case '/game/save' :

			$gameId = $_REQUEST['id'];
			$time = $_REQUEST['time'];

			// met à jour la partie avec le temps du joueur
			$game = $entityManager->getRepository('Memoire\MemoireGame')->findOneBy(['gameId' => $gameId]);
			$game->setTime($time);

			$entityManager->flush();
			break;
		default:
			http_response_code(404);
			include __DIR__ . '/../src/vues/_header.php';
			require __DIR__ . '/../src/vues/404.php';
			include __DIR__ . '/../src/vues/_footer.php';
			break;
	}
}
else 
{
	if (! is_null($finalTypeMime))
	{
		header('content-type: ' . $finalTypeMime);
	}
	include __DIR__ . $request;
}