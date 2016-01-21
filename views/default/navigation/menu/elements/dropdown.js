require(['jquery', 'jquery-ui'], function($) {
	$(document).on('click', '.elgg-menu-dropdown li:has(.elgg-child-menu) > a', function () {
		var $elem = $(this);
		var $menuItem = $elem.closest('li');
		var $childMenu = $menuItem.find('.elgg-child-menu').eq(0);
		if ($childMenu.is(':visible')) {
			$childMenu.removeClass('elgg-state-active').fadeOut();
		} else {
			$childMenu.addClass('elgg-state-active elgg-menu-hover').fadeIn().position({
				my: 'right top+5px',
				at: 'right bottom',
				collision: 'fit fit',
				of: $elem
			});
		}
		return false;
	});
});