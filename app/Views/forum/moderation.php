<h2>Moderation Panel</h2>
<?php foreach($reports as $report): ?>
<div><?= esc($report['reason']); ?></div>
<?php endforeach; ?>
