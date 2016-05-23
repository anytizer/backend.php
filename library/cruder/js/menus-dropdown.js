/**
 * Handle Date Pickers (jQuery and UI)
 * <script type="text/javascript" src="//code.jquery.com/jquery-latest.js"></script>
 *
 * <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
 * <script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
 */
function install_datepicker_handlers()
{
	$("input[rel=date]").datepicker({
		dateFormat: "yy-mm-dd",
		minDate: "-1D",
		defaultDate: "0"
	});
}

$(document).ready(function()
{
	$(".nav ul ").css({display: "none"}); // Opera Fix
	$(".nav li").hover(function()
	{
		$(this).find('ul:first').css({visibility: "visible", display: "block"}).show(400);
	}, function()
	{
		$(this).find('ul:first').css({visibility: "hidden"});
	});

	var ul = $('.menu');
	if(ul.length)
	{
		ul.children('li').hover(function()
		{
			$(this).children('ul').show();
		},function()
		{
			$(this).children('ul').hide();
		}).children('ul').hide().parent().addClass('parent');
	}

	install_datepicker_handlers();
});