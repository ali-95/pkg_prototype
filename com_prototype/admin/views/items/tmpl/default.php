<?php
/**
 * @package    Prototype Component
 * @version    1.4.3
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
HTMLHelper::stylesheet('media/com_prototype/css/admin-items.min.css', array('version' => 'auto'));
HTMLHelper::_('script', 'media/com_prototype/js/admin-items.min.js', array('version' => 'auto'));

$app       = Factory::getApplication();
$doc       = Factory::getDocument();
$user      = Factory::getUser();
$userId    = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));

$columns = 9;

?>

<form action="<?php echo Route::_('index.php?option=com_prototype&view=items'); ?>" method="post" name="adminForm"
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
			<table id="itemList" class="table table-striped">
				<thead>
				<tr>
					<th width="1%" class="center">
						<?php echo HTMLHelper::_('grid.checkall'); ?>
					</th>
					<th width="2%" style="min-width:100px" class="center hidden-phone">
						<?php echo HTMLHelper::_('searchtools.sort', 'JSTATUS', 'i.state', $listDirn, $listOrder); ?>
					</th>
					<th width="1%" style="min-width:100px" class="center">
						<?php echo Text::_('COM_PROTOTYPE_PRESETS_ICON'); ?>
					</th>
					<th style="min-width:100px" class="nowrap">
						<?php echo HTMLHelper::_('searchtools.sort', 'JGLOBAL_TITLE', 'i.title', $listDirn, $listOrder); ?>
					</th>
					<th width="15%" class="nowrap hidden-phone">
						<?php echo Text::_('JGLOBAL_FIELD_PRICE_LABEL'); ?>
					</th>
					<th width="15%" class="nowrap hidden-phone">
						<?php echo Text::_('COM_PROTOTYPE_ITEM_PAYMENT_NUMBER'); ?>
					</th>
					<th width="10%" class="nowrap hidden-phone">
						<?php echo HTMLHelper::_('searchtools.sort', 'COM_PROTOTYPE_ITEM_PAYMENT_DOWN', 'i.payment_down', $listDirn, $listOrder); ?>
					</th>
					<th width="10%" class="nowrap hidden-phone">
						<?php echo HTMLHelper::_('searchtools.sort', 'JAUTHOR', 'i.created_by', $listDirn, $listOrder); ?>
					</th>
					<th width="10%" class="nowrap hidden-phone">
						<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_REGION', 'region_name', $listDirn, $listOrder); ?>
					</th>
					<th width="10%" class="nowrap hidden-phone">
						<?php echo HTMLHelper::_('searchtools.sort', 'JDATE', 'i.date', $listDirn, $listOrder); ?>
					</th>
					<th width="1%" class="nowrap hidden-phone">
						<?php echo HTMLHelper::_('searchtools.sort', 'COM_PROTOTYPE_ITEMS_HITS', 'i.hits', $listDirn, $listOrder); ?>
					</th>
					<th width="1%" class="nowrap hidden-phone center">
						<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'i.id', $listDirn, $listOrder); ?>
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
					$canEdit = $user->authorise('core.edit', '#__prototype_items.' . $item->id);
					$canChange = $user->authorise('core.edit.state', '#__prototype_items' . $item->id);
					?>
					<tr item-id="<?php echo $item->id ?>">
						<td class="center">
							<?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
						</td>
						<td class="center">
							<div class="btn-group">
								<a class="btn btn-micro hasTooltip" title="<?php echo Text::_('JACTION_EDIT'); ?>"
								   href="<?php echo Route::_('index.php?option=com_prototype&task=item.edit&id=' . $item->id); ?>">
									<span class="icon-apply icon-white"></span>
								</a>
								<?php echo HTMLHelper::_('jgrid.published', $item->state, $i, 'items.', $canChange, 'cb'); ?>
								<?php
								if ($canChange)
								{
									HTMLHelper::_('actionsdropdown.' . ((int) $item->state === -2 ? 'un' : '') . 'trash', 'cb' . $i, 'items');
									echo HTMLHelper::_('actionsdropdown.render', $this->escape($item->title));
								}
								?>
							</div>
						</td>
						<td class="center hidden-phone">
							<?php if ($item->preset && !empty($item->preset->icon)): ?>
								<?php echo HTMLHelper::image($item->preset->icon, $item->title); ?>
							<?php endif; ?>
						</td>
						<td>
							<div>
								<?php if ($canEdit) : ?>
									<a class="hasTooltip" title="<?php echo Text::_('JACTION_EDIT'); ?>"
									   href="<?php echo Route::_('index.php?option=com_prototype&task=item.edit&id=' . $item->id); ?>">
										<?php echo $this->escape($item->title); ?>
									</a>
								<?php else : ?>
									<?php echo $this->escape($item->title); ?>
								<?php endif; ?>
							</div>
							<div class="small">
								<span><?php echo Text::_('JCATEGORY'); ?>: </span>
								<?php if ($item->category->parent_level > 1) : ?>
									<span><?php echo $item->category->parent_title; ?></span>
								<?php endif; ?>
								<span><?php echo(!empty($item->category->title) ? $item->category->title : Text::_('JROOT')); ?></span>
								<span><?php echo $item->location; ?></span>
							</div>
						</td>
						<td class="hidden-phone">
							<?php if ($item->price): ?>
								<div>
									<strong><?php echo ($item->price > 0) ? $item->price . ' ₽' : '---'; ?></strong>
								</div>
								<?php if ($item->preset->price): ?>
									<div class="muted"><?php echo $item->preset->price->title; ?></div>
								<?php endif; ?>
							<?php endif; ?>
						</td>
						<td class="hidden-phone">
							<a data-filter-payment_number="<?php echo $item->payment_number; ?>">
								<?php echo $this->escape($item->payment_number); ?>
							</a>
						</td>
						<td class="hidden-phone">
							<?php echo $item->payment_down > 0 ? HTMLHelper::_('date', $item->payment_down,
								Text::_('DATE_FORMAT_LC1')) : '' ?>
						</td>
						<td class="hidden-phone">
							<?php if ((int) $item->created_by != 0) : ?>
								<div class="author">
									<div>
										<div class="name">
											<a class="hasTooltip nowrap" title="<?php echo Text::_('JACTION_EDIT'); ?>"
											   target="_blank"
											   href="<?php echo Route::_('index.php?option=com_users&task=user.edit&id='
												   . (int) $item->author_id); ?>">
												<?php echo $item->author_name; ?>
											</a>
										</div>
										<?php if ($item->author_job): ?>
											<div class="job">
												<a class="hasTooltip nowrap"
												   title="<?php echo Text::_('JACTION_EDIT'); ?>"
												   target="_blank"
												   href="<?php echo Route::_('index.php?option=com_companies&task=company.edit&id='
													   . $item->author_job_id); ?>">
													<?php echo $this->escape($item->author_job_name); ?>
												</a>
											</div>
										<?php endif; ?>
									</div>
								</div>
							<?php endif; ?>
						</td>

						<td class="small hidden-phone nowrap">
							<?php echo $this->escape($item->region_name); ?>
						</td>
						<td class="nowrap small hidden-phone">
							<?php echo $item->date > 0 ? HTMLHelper::_('date', $item->date,
								Text::_('DATE_FORMAT_LC2')) : '-' ?>
						</td>

						<td class="hidden-phone center">
							<span class="badge badge-info">
								<?php echo (int) $item->hits; ?>
							</span>
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

