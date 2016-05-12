function getvalue(str)
{
	//$('#currencyFrom').val(str);
	//alert($('#currencyFrom').val());
}

function setCurrencyValue(argCurrencyType, argCurrencyValue, argCurrencyText)
{
	//alert(argCurrencyType+'<==========>'+argCurrencyValue+'<==========>'+argCurrencyText);
	if(argCurrencyType == 'from')
	{
		$('#currencyFrom').val(argCurrencyValue);
		$('#selectedTxtFromDiv').html(argCurrencyText);
	}
	else
	{
		$('#currencyTo').val(argCurrencyValue);
		$('#selectedTxtToDiv').html(argCurrencyText);
	}
	
}

$(document).click (function (event) 
{
	var targetID 		= event.target.id;
	var targetClassName = event.target.className;
	//alert(targetID+'=========='+targetClassName);
	if(targetID == 'selectedTxtFromDiv')
	{
		$("#frmFromCurrencyOptions").show();
		$("#frmToCurrencyOptions").hide();
	}
	else if(targetID == 'selectedTxtToDiv')
	{
		$("#frmFromCurrencyOptions").hide();
		$("#frmToCurrencyOptions").show();
	}
	else
	{
		$("#frmFromCurrencyOptions").hide();
		$("#frmToCurrencyOptions").hide();
	}
	
});

$(document).ready(function()
{
	$('#convert').click(function()
	{
		//Get all the values
		var amount 	= 	$('#amount').val();
		var from 	= 	$('#currencyFrom').val();
		var to 		= 	$('#currencyTo').val();
		//alert(amount);
		//alert(from);
		//alert(to);
		//Make data string
		var dataString = "amount=" + amount + "&from=" + from + "&to=" + to;
		$.ajax(
		{
			type: "POST",
			url: SITE_ROOT_URL + "common/ajax/ajax_converter.php",
			data: dataString,
			success: function(data)
			{
				//Show results div
				$('#results').show();
				
				//Put received response into result div
				$('#results').html(data);
			}
		});
	});
});