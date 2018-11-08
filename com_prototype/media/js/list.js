/*
 * @package    Prototype Component
 * @version    1.3.0
 * @author     Nerudas  - nerudas.ru
 * @copyright  Copyright (c) 2013 - 2018 Nerudas. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link       https://nerudas.ru
 */

(function ($) {
	$(document).ready(function () {
		var joomlaParams = Joomla.getOptions('prototypeList', '');
		// Balloon
		$('body').on('click', '[data-prototype-show-balloon]', function () {
			var item = $(this),
				id = $(item).data('prototype-show-balloon'),
				listElement = $('[data-prototype-item="' + id + '"]');
			$(listElement).attr('data-viewed', 'true');
			getBalloon(id);
		});

		function getBalloon(id) {
			if ($('body').find('[data-prototype-list-balloon]').length == 0) {
				$(joomlaParams.balloonBlock).appendTo($('body'));
			}
			var ajaxData = [];
			ajaxData.push({name: 'item_id', value: id});
			var container = $('[data-prototype-list-balloon]'),
				content = $(container).find('[data-prototype-list-balloon-content]'),
				loading = $(container).find('[data-prototype-list-balloon-loading]'),
				error = $(container).find('[data-prototype-list-balloon-error]');
			$.ajax({
				type: 'GET',
				dataType: 'json',
				url: '/index.php?option=com_prototype&task=items.getBalloon',
				cache: false,
				data: ajaxData,
				beforeSend: function () {
					$(content).html('');
					$(error).hide();
					$(loading).show();
					showPrototypeListBalloon();
				},
				complete: function () {
					$(loading).hide();
				},
				success: function (response) {
					if (response.success) {
						var data = response.data;
						$(content).html(data.html);
					}
					else {
						$(error).show();
					}
				},
				error: function () {
					$(error).show();
				}
			});
		}
// Author
		$('body').on('click', '[data-prototype-show-author]', function () {
			var item = $(this),
				id = $(item).data('prototype-show-author'),
				listElement = $('[data-prototype-item="' + id + '"]');
			$(listElement).attr('data-viewed', 'true');
			getAuthor(id);
		});

		function getAuthor(id) {
			if ($('body').find('[data-prototype-list-author]').length == 0) {
				$(joomlaParams.authorBlock).appendTo($('body'));
			}
			var ajaxData = [];
			ajaxData.push({name: 'item_id', value: id});
			var container = $('[data-prototype-list-author]'),
				content = $(container).find('[data-prototype-list-author-content]'),
				loading = $(container).find('[data-prototype-list-author-loading]'),
				error = $(container).find('[data-prototype-list-author-error]');
			$.ajax({
				type: 'GET',
				dataType: 'json',
				url: '/index.php?option=com_prototype&task=items.getAuthor',
				cache: false,
				data: ajaxData,
				beforeSend: function () {
					$(content).html('');
					$(error).hide();
					$(loading).show();
					showPrototypeListAuthor();
				},
				complete: function () {
					$(loading).hide();
				},
				success: function (response) {
					if (response.success) {
						var data = response.data;
						$(content).html(data.html);
					}
					else {
						$(error).show();
					}
				},
				error: function () {
					$(error).show();
				}
			});
		}
	});
})(jQuery);