// Ajax Library



function createREQ()

{

	try

	{

		req = new XMLHttpRequest(); /* e.g. Firefox */

	}

	catch(err1)

	{

		try

		{

			req = new ActiveXObject('Msxml2.XMLHTTP'); /* some versions IE */

		}

		catch(err2)

		{

			try

			{

				req = new ActiveXObject("Microsoft.XMLHTTP"); /* some versions IE */

			}

			catch(err3)

			{

				req = false;

			}

		 }

	 }

	 

     return req;

}



function requestGET(url, query, req)

{	

	myRand=parseInt(Math.random()*99999999);

	req.open("GET",url+'?'+query+'&rand='+myRand,true);

	req.send(null);

}



function requestPOST(url, query, req)

{

	req.open("POST", url,true);

	req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

	req.send(query);

}



function doCallback(callback,item)

{	//alert(item);
	if(callback.indexOf('(') == (callback.indexOf(')') - 1) || callback.indexOf('(')  < 0)
	{
		callback = callback  + '(item)';
	}
	else
	{
		arrCallback = callback.split(')');
		arrCallback['0'] = arrCallback['0'] + ', item)';
		callback = arrCallback['0'];
	}
	eval(callback);

}



function doAjax(url,query,callback,reqtype,option,getxml)

{	

	// create the XMLHTTPRequest object instance

	var myreq = createREQ();



	myreq.onreadystatechange = function()

	{

		if(myreq.readyState == 4)

		{

			if(myreq.status == 200)

			{

				var item = myreq.responseText;

				if(getxml==1)

				{

					item = myreq.responseXML;

				}

				doCallback(callback, item);

			}

		}

		else

		{

			var item;

			if(option=='1')

			{

				item = '<img src="common/images/ajax_loader.gif" title="Loading..." alt="Loading..." />';	

				doCallback(callback, item);

			}

			else if(option=='2')

			{

				item = '<img src="common/images/ajax_loader.gif" title="Loading..." alt="Loading..." style="float:none" />';	

				doCallback(callback, item);

			}

			else

			{

				item = '';

			}

		}

	}

	if(reqtype=='post')

	{

		requestPOST(url,query,myreq);

	}

	else

	{

		requestGET(url,query,myreq);

	}

}