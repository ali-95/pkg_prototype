<?php
/**
 * @package    Prototype Component
 * @version    1.1.1
 * @author     Nerudas  - nerudas.ru
 * @copyright  Copyright (c) 2013 - 2018 Nerudas. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link       https://nerudas.ru
 */

defined('_JEXEC') or die;

?>
<div class="items">
	<?php if ($this->items): ?>
		<?php foreach ($this->items as $item): ?>
			<div class="item" data-prototype-item="<?php echo $item->id; ?>">
				<h2><a data-prototype-show="<?php echo $item->id; ?>"><?php echo $item->title; ?></a></h2>
			</div>
			<hr data-prototype-item="<?php echo $item->id; ?>">
		<?php endforeach; ?>
	<?php endif; ?>
</div>


