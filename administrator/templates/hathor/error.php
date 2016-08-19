<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Template.hathor
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$app = JFactory::getApplication();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $this->title; ?> <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></title>
	<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo  $this->template; ?>/css/error.css" type="text/css" />
	<?php if ($app->get('debug_lang', '0') == '1' || $app->get('debug', '0') == '1') : ?>
		<!-- Load additional CSS styles for debug mode-->
		<link rel="stylesheet" href="<?php echo JUri::root(); ?>/media/cms/css/debug.css" type="text/css" />
	<?php endif; ?>
	<!-- Load additional CSS styles for rtl sites -->
	<?php if ($this->direction == 'rtl') : ?>
		<link href="<?php echo $this->baseurl; ?>/templates/<?php echo  $this->template; ?>/css/template_rtl.css" rel="stylesheet" type="text/css" />
	<?php endif; ?>

</head>
<body class="errors">
	<div>
		<h1>
			<?php echo $this->error->getCode(); ?> - <?php echo JText::_('JERROR_AN_ERROR_HAS_OCCURRED'); ?>
		</h1>
	</div>
	<div>
		<p>
			<?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?>
			<?php if ($this->debug) : ?>
				<br/><?php echo htmlspecialchars($this->error->getFile(), ENT_QUOTES, 'UTF-8');?>:<?php echo $this->error->getLine(); ?>
			<?php endif; ?>
		</p>
		<p><a href="index.php"><?php echo JText::_('JGLOBAL_TPL_CPANEL_LINK_TEXT'); ?></a></p>
		<?php if ($this->debug) : ?>
			<div>
				<?php echo $this->renderBacktrace(); ?>
				<?php // Check if there are more Exceptions and render their data as well ?>
				<?php if ($this->error->getPrevious()) : ?>
					<?php $loop = true; ?>
					<?php // Reference $this->_error here and in the loop as setError() assigns errors to this property and we need this for the backtrace to work correctly ?>
					<?php // Make the first assignment to setError() outside the loop so the loop does not skip Exceptions ?>
					<?php $this->setError($this->_error->getPrevious()); ?>
					<?php while ($loop === true) : ?>
						<p><strong><?php echo JText::_('JERROR_LAYOUT_PREVIOUS_ERROR'); ?></strong></p>
						<p><?php echo htmlspecialchars($this->_error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></p>
						<?php echo $this->renderBacktrace(); ?>
						<?php $loop = $this->setError($this->_error->getPrevious()); ?>
					<?php endwhile; ?>
					<?php // Reset the main error object to the base error ?>
					<?php $this->setError($this->error); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="clr"></div>
	<noscript>
			<?php echo JText::_('JGLOBAL_WARNJAVASCRIPT'); ?>
	</noscript>
</body>
</html>
