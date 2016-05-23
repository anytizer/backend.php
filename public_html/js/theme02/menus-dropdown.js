$(document).ready(function()
{
	$(".nav ul").css({display: "none"}); // Opera Fix
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
});