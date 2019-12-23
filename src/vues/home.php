

<div id="conteneur">
	<div id="titre">Meilleurs Scores - <?php echo (2 * $config['nb_paires']); ?> images</div>
	<div>
		<ol>
		<?php foreach ($gameList as $game) : ?>
			<li><?php echo $game->getTime(); ?> s</li>
		<?php endforeach; ?>
		</ol>
	</div>
	<a href="/game">Nouvelle Partie</a>
</div>