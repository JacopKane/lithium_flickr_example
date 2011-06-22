<?php foreach($flickrDebugVars as $flickrDebugVar => $value): ?>
	<strong><?= $flickrDebugVar ?></strong>
	<p>&nbsp;</p>
	<pre><?php print_r($value); ?></pre>
	<p>&nbsp;</p>
<?php endforeach; ?>