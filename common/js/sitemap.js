function showCategoryProducts(argId)
{
	if($('#product_'+argId).is(':visible'))
	{
		$('#product_'+argId).hide();
		$('#product_'+argId).hide();
		$('#category_'+argId).removeClass('minus');
		$('#category_'+argId).addClass('plus');
		
	}
	else
	{
		$('#product_'+argId).show();
		$('#product_'+argId).show();
		$('#category_'+argId).removeClass('plus');
		$('#category_'+argId).addClass('minus');
		
	}
}