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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\CMS\Layout\LayoutHelper;

HTMLHelper::_('bootstrap.tooltip');
HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('formbehavior.chosen', 'select');
HTMLHelper::stylesheet('media/com_prototype/css/admin-placemarks.css', array('version' => 'auto'));

$app       = Factory::getApplication();
$doc       = Factory::getDocument();
$user      = Factory::getUser();
$userId    = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));

$columns = 5;

?>

<form action="<?php echo Route::_('index.php?option=com_prototype&view=placemarks'); ?>" method="post" name="adminForm"
	  id="adminForm">
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php echo LayoutHelper::render('joomla.searchtools.default',
			array('view' => $this, 'options' => array('filtersHidden' => false))); ?>
		<?php if (empty($this->items)) : ?>
			<div class="alert alert-no-items">
				<?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
			</div>
		<?php else : ?>
			<table id="placemarkList" class="table table-striped">
				<thead>
				<tr>
					<th width="1%" class="center">
						<?php echo HTMLHelper::_('grid.checkall'); ?>
					</th>
					<th width="2%" style="min-width:100px" class="center">
						<?php echo HTMLHelper::_('searchtools.sort', 'JSTATUS', 'p.state', $listDirn, $listOrder); ?>
					</th>
					<th style="min-width:100px" class="nowrap">
						<?php echo HTMLHelper::_('searchtools.sort', 'JGLOBAL_TITLE', 'p.title', $listDirn, $listOrder); ?>
					</th>
					<th width="30%" class="nowrap hidden-phone">
						<?php echo Text::_('COM_PROTOTYPE_PLACEMARK_DEMO'); ?>
					</th>
					<th width="10%" class="nowrap hidden-phone">
						<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ACCESS', 'p.access', $listDirn, $listOrder); ?>
					</th>
					<th width="1%" class="nowrap hidden-phone center">
						<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'p.id', $listDirn, $listOrder); ?>
					</th>
				</tr>
				</thead>
				<tfoot>
				<tr>
					<td colspan="<?php echo $columns; ?>">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
				</tfoot>
				<tbody>

				<?php foreach ($this->items as $i => $item) :
					$canEdit = $user->authorise('core.edit', '#_prototype_placemarks.' . $item->id);
					$canChange = $user->authorise('core.edit.state', '#__prototype_placemarks' . $item->id);
					?>
					<tr>
						<td class="center">
							<?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
						</td>
						<td class="center">
							<div class="btn-group">
								<a class="btn btn-micro hasTooltip" title="<?php echo Text::_('JACTION_EDIT'); ?>"
								   href="<?php echo Route::_('index.php?option=com_prototype&task=placemark.edit&id=' . $item->id); ?>">
									<span class="icon-apply icon-white"></span>
								</a>
								<?php echo HTMLHelper::_('jgrid.published', $item->state, $i, 'placemarks.', $canChange, 'cb'); ?>
								<?php
								if ($canChange)
								{
									HTMLHelper::_('actionsdropdown.' . ((int) $item->state === -2 ? 'un' : '') . 'trash', 'cb' . $i, 'placemarks');
									echo HTMLHelper::_('actionsdropdown.render', $this->escape($item->title));
								}
								?>
							</div>
						</td>
						<td>
							<div>
								<?php if ($canEdit) : ?>
									<a class="hasTooltip" title="<?php echo Text::_('JACTION_EDIT'); ?>"
									   href="<?php echo Route::_('index.php?option=com_prototype&task=placemark.edit&id=' . $item->id); ?>">
										<?php echo $item->title; ?>
									</a>
								<?php else : ?>
									<?php echo $this->escape($item->title); ?>
								<?php endif; ?>
							</div>
						</td>
						<td class="hidden-phone center">
							<?php echo $item->demo; ?>
						</td>
						<td class="small hidden-phone">
							<?php echo $this->escape($item->access_level); ?>
						</td>
						<td class="hidden-phone center">
							<?php echo $item->id; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
		<input type="hidden" name="task" value=""/>
		<input type="hidden" name="boxchecked" value="0"/>
		<?php echo HTMLHelper::_('form.token'); ?>
	</div>
</form>