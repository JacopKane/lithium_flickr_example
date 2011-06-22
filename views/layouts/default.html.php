<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
?>
<!doctype html>
<html>
<head>
	<?= $this->html->charset();?>
	<title>Application > <?php echo $this->title(); ?></title>
	<?= $this->html->style(array('http://localhost/anotherapp/debug', 'lithium')); ?>
	<?= $this->scripts(); ?>
	<?= $this->html->link('Icon', null, array('type' => 'icon')); ?>
</head>
<body class="app">
	<div id="container">
		<div id="header">
			<h1>Application</h1>
			<h2>
				Powered by <?php echo $this->html->link('Lithium', 'http://lithify.me/'); ?>.
			</h2>
		</div>
		<div id="content">
			<?= $this->content(); ?>
		</div>
	</div>
</body>
</html>
