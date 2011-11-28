 
function loadPage(url , target , confirms)
{
/*	
	
	 $('.loading').show();
	if(confirms)
	{
		if(confirm(confirms))
			 $(target).load(url);
	}else	
		$(target).load(url);
	
	$('.loading').hide();	*/	
	
	if(confirms)
	{
		if(confirm(confirms))
		{
			$('.loading').show();
			$.post(url ,{} , function(data)
			{
		 
				$(target).html(data);	
				$('.loading').hide();
			});
	
		}
	}else	
	{	 
		$('.loading').show();
		$.post(url ,{} , function(data)
		{
	 
			$(target).html(data);	
			$('.loading').hide();
		});
	}
}

function sendForm(url ,  target , frmID  )
{
	
	$('.loading').show();
	$.post(url , $('#'+frmID).serialize() , function(data)
	{
 		//alert($('#'+frmID).serialize());
		$(target).html(data);	
		$('.loading').hide();
	});
}

function addcomment(url , div , paramKey , paramValue)
{
		
}

function sendGet()
{
	
}