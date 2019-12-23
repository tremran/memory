<?php 

include __DIR__ . '/../src/include.php'; 

use Memoire\MemoireGame;

$request = $_SERVER['REQUEST_URI'];
$request = explode('?', $request)[0];

$dossier_front = ['css', 'img', 'js'];

$estRessource = false;
foreach ($dossier_front as $folder)
{
	if (substr($request, 1, strlen($folder)) == $folder)
	{
		$estRessource = true;
	}
}
	
if (! $estRessource) 
{
	include __DIR__ . '/../src/vues/_header.php';
	switch ($request) {
		case '' :
		case '/' :
			// crée une nouvelle partie
			$dqlQuery = 'Select g FROM Memoire\MemoireGame g where g.pairCount = :pair_count AND g.time IS NOT NULL ORDER BY g.time ASC';
			$query = $entityManager->createQuery($dqlQuery);
			$query->setParameter('pair_count', $config['nb_paires']);
			$query->setMaxResults(10);

			$gameList = $query->getResult();

			require __DIR__ . '/../src/vues/home.php';
			break;
		case '/game' :
			$gameId = uniqid();
			// crée une nouvelle partie
			$game = new MemoireGame($gameId, $config['nb_paires']);
			$entityManager->persist($game);
			$entityManager->flush();

			require __DIR__ . '/../src/vues/game.php';
			break;
				
		case '/game/save' :

			$gameId = $_REQUEST['id'];
			$time = $_REQUEST['time'];

			// crée une nouvelle partie
			$game = $entityManager->getRepository('Memoire\MemoireGame')->findOneBy(['gameId' => $gameId]);
			$game->setTime($time);

			$entityManager->flush();

			break;
		case '/high-scores' :
			require __DIR__ . '/../src/vues/highscores.php';
			break;
		default:
			http_response_code(404);
			require __DIR__ . '/../src/vues/404.php';
			break;
	}
	include __DIR__ . '/../src/vues/_footer.php';
}
else 
{
	include __DIR__ . $request;
}