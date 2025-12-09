<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html>

<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo 'Seu João Serviços' ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
	echo $this->Html->meta('icon');

	echo $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css');
	echo $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css');
	echo $this->Html->css('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');

	echo $this->Html->css('style');
	echo $this->Html->css('dropdown');
	echo $this->Html->css('index-employee');
	echo $this->Html->css('modal-upload');
	echo $this->Html->css('modal-success');
	echo $this->Html->css('toast');

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	?>

	<link rel="preconnect" href="https://rsms.me/">
	<link rel="stylesheet" href="https://rsms.me/inter/inter.css">

</head>

<body>
	<?php echo $this->Flash->render(); ?>
	<div id="toast-container"></div>
	<div class="container">
		<header>
			<!-- //usar para solicitações de serviço -->
		</header>
		<div class="content">

			<?php if ($this->Session->check('Message.flash')): ?>
				<?php $flash = $this->Session->read('Message.flash'); ?>
				<script>
					document.addEventListener('DOMContentLoaded', function() {
						toast(
							<?php echo json_encode($flash['message']); ?>,
							'<?php
								$type = 'info';
								if (isset($flash['element'])) {
									if (strpos($flash['element'], 'success') !== false) {
										$type = 'success';
									} elseif (strpos($flash['element'], 'error') !== false) {
										$type = 'error';
									} elseif (strpos($flash['element'], 'warning') !== false) {
										$type = 'warning';
									}
								}
								echo $type;
								?>'
						);
					});
				</script>
				<?php $this->Session->delete('Message.flash'); ?>
			<?php endif; ?>
			
			<?php echo $this->fetch('content'); ?>
		</div>
		<footer>
			<?php /*echo $this->Html->link(
				$this->Html->image('github.png', array('alt' => 'github mauricio mateus', 'border' => '0', 'width' => '25', 'height' => '25')),
				'https://github.com/mauriciomateus02',
				array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
			);

			echo $this->Html->tag('p', 'at Mauricio Mateus');
			**/ ?>
		</footer>
	</div>

	<?php
	echo $this->Html->script('https://code.jquery.com/jquery-3.6.0.min.js');
	echo $this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js');
	echo $this->Html->script('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js');
	echo $this->Html->script('mask.js');
	echo $this->Html->script('upload-image.js');
	echo $this->Html->script('dropdown.js');
	echo $this->Html->script('form_restore.js');
	echo $this->Html->script('modal-upload.js');
	echo $this->Html->script('delete-employee.js');
	echo $this->Html->script('modal-success.js');
	echo $this->Html->script('toast.js');
	?>

</body>

</html>