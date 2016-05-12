<?php
/** 
*
* Module name : CreateOrder
*
* Parent module : None
*
* Date created : 20th July 2013
*
* Date last modified : 20th July 2013
*
* Author : Rupesh Parmar
*
* Last modified by : Rupesh Parmar
*
* Comments : Class for sorting the database records
*
*/ 

class CreateOrder

{

    /** 
    *
    * Variable declaration begins
    *
    */ 

    var $orderOptions;

        var $orderBlock;

    var $orderEventBlock;

    var $sortBy;

    var $orderBy;

        var $append;

        var $prepend;

    var $arrow;

    /** 
    *
    * Variable declaration ends
    *
    */ 



	/** 
	*
	* Function name : CreateOrder
	*
	* Return type : none
	*
	* Date created : 20th July 2013
	*
	* Date last modified : 20th July 2013
	*
	* Author : Rupesh Parmar
	*
	* Last modified by : Rupesh Parmar
	*
	* Comments : This is constructor of the class
	*
	* User instruction : $objOrder = new CreateOrder($sortBy, $orderBy)
	*
	*/ 

    function CreateOrder($sortBy, $orderBy, $arrow='bulet_up.gif')

    {

        $this->arrow = $arrow;

        $this->sortBy = $sortBy;

        $this->orderBy = $orderBy;

        $this->orderOptions = ''.$this->sortBy.' '.$this->orderBy;

    }



    	/** 
	*
	* Function name : extra
	*
	* Return type : none
	*
	* Date created : 20th July 2013
	*
	* Date last modified : 20th July 2013
	*
	* Author : Rupesh Parmar
	*
	* Last modified by : Rupesh Parmar
	*
	* Comments : Function will append the passed string in query string
	*
	* User instruction : $objOrder->extra($str)
	*
	*/ 

    function extra($str)

    {

        $this->extra .= $str;

    }



    	/** 
	*
	* Function name : append
	*
	* Return type : none
	*
	* Date created : 20th July 2013
	*
	* Date last modified : 20th July 2013
	*
	* Author : Rupesh Parmar
	*
	* Last modified by : Rupesh Parmar
	*
	* Comments : Function will append the passed string in column title
	*
	* User instruction : $objOrder->append($str)
	*
	*/ 

    function append($str)

    {

        $this->append = $str;

    }



    	/** 
	*
	* Function name : prepend
	*
	* Return type : none
	*
	* Date created : 20th July 2013
	*
	* Date last modified : 20th July 2013
	*
	* Author : Rupesh Parmar
	*
	* Last modified by : Rupesh Parmar
	*
	* Comments : Function will prefix the passed string in column title
	*
	* User instruction : $objOrder->prepend($str)
	*
	*/ 

    function prepend($str)

    {

        $this->prepend = $str;

    }



    	/** 
	*
	* Function name : addColumn
	*
	* Return type : none
	*
	* Date created : 20th July 2013
	*
	* Date last modified : 10 October 2013
	*
	* Author : Rupesh Parmar
	*
	* Last modified by : Aditya Pratap Singh
	*
	* Comments : Function will generate the column title with the link and normal links if function does't have Order By Field
	*
	* User instruction : $objOrder->addColumn($orderTitle, $orderField, $URL, $styleClass)
	*
	*/ 

    function addColumn($orderTitle, $orderField, $URL='',$styleClass='')

    {
        if($orderField !=''){
        if($this->orderBy == 'ASC')

        {

            $orderBy = 'DESC';



            if(strchr($_SERVER['PHP_SELF'],'admin'))

            {

                $this->arrow = 'images/up.png';

            }

            else

            {

                $this->arrow = 'images/up.png';

            }

        }

        else if($this->orderBy == 'DESC')

        {

            $orderBy = 'ASC';



            if(strchr($_SERVER['PHP_SELF'],'admin'))

            {

                $this->arrow = 'images/down.png';

            }

            else

            {

                 $this->arrow = 'images/down.png';

            }

        }


        
        if($this->sortBy == $orderField )

        {

            $imgStr = '&nbsp;<img src="'.$this->arrow.'" alt="Sorted in : '.$this->orderBy.'ENDING order" title="Sorted in : '.$this->orderBy.'ENDING order" />';

        }

        else if($this->sortBy == ' ORDER BY '.$orderField)

        {

            $imgStr = '&nbsp;<img src="'.$this->arrow.'" alt="Sorted in : '.$this->orderBy.'ENDING order" title="Sorted in : '.$this->orderBy.'ENDING order" />';

        }

        else

        {
        	//$imgStr = '&nbsp;<img src="'.$this->arrow.'" alt="Sorted in : '.$this->orderBy.'ENDING order" title="Sorted in : '.$this->orderBy.'ENDING order" />';
            $imgStr = '';

        }



        if($URL=='no')

        {

            $this->orderBlock .= '<th class="'.$styleClass.'" style="text-align:left">'.$this->prepend.$orderTitle.$this->append.'</th>';

        }

        else

        {
        	

            if($orderField == 'PageStatus' || $orderField == 'BlogStatus' || $orderField =='NewsletterSubscriberStatus')

            {

                $this->orderBlock .= '<th class="'.$styleClass.'" style="text-align:left"><strong>'.$this->prepend.'<a title="Sort this column in '.$orderBy.'ENDING order" style="color:#000000" href="'.$URL.'?sortBy='.$orderField.'&amp;orderBy='.$orderBy.$this->extra.'">'.$orderTitle.'</a></strong>'.$imgStr.$this->append.'</th>';

            }

            else

            {
            	//echo $orderField; die;
            	$this->orderBlock .= '<th class="'.$styleClass.'" style="text-align:left"><strong>'.$this->prepend.'<a title="Sort this column in '.$orderBy.'ENDING order" style="color:#000000" href="'.$URL.'?sortBy='.$orderField.'&amp;orderBy='.$orderBy.$this->extra.'">'.$orderTitle.'</a></strong>'.$imgStr.$this->append.'</th>';
				
            }

        }
        }else{
            $this->orderBlock .= '<th style="width:15%; text-align:left;" valign="top">'.$orderTitle.'</th>';
        }

    }



    	/** 
	*
	* Function name : orderBlock
	*
	* Return type : String
	*
	* Date created : 20th July 2013
	*
	* Date last modified : 20th July 2013
	*
	* Author : Rupesh Parmar
	*
	* Last modified by : Rupesh Parmar
	*
	* Comments : Function will return the column title with the link
	*
	* User instruction : $objOrder->orderBlock()
	*
	*/

    function orderBlock()

    {

        return $this->orderBlock;

    }



    	/** 
	*
	* Function name : orderOptions
	*
	* Return type : String
	*
	* Date created : 20th July 2013
	*
	* Date last modified : 20th July 2013
	*
	* Author : Rupesh Parmar
	*
	* Last modified by : Rupesh Parmar
	*
	* Comments : Function will return the order by clause
	*
	* User instruction : $objOrder->orderOptions()
	*
	*/ 

    function orderOptions()

    {

        return $this->orderOptions;

    }



	/** 
	*
	* Function name : addFrontEventColumn
	*
	* Return type : none
	*
	* Date created : 20th July 2013
	*
	* Date last modified : 14th February 2008
	*
	* Author : Rupesh Parmar
	*
	* Last modified by : Charanjeet Singh
	*
	* Comments : Function will generate the column title with the link
	*
	* User instruction : $objOrder->addFrontEventColumn($orderTitle, $orderField, $URL, $styleClass)
	*
	*/ 

    function addFrontEventColumn($orderTitle, $orderField, $URL='',$styleClass='')

    {

        if($this->orderBy == 'ASC')

        {

            $orderBy = 'DESC';



            if(strchr($_SERVER['PHP_SELF'],'admin'))

            {

                $this->arrow = 'common/images/up.png';

            }

            else

            {

                $this->arrow = 'common/images/up.png';

            }

        }

        else if($this->orderBy == 'DESC')

        {

            $orderBy = 'ASC';



            if(strchr($_SERVER['PHP_SELF'],'admin'))

            {

                $this->arrow = 'common/images/down.png';

            }

            else

            {

                 $this->arrow = 'common/images/down.png';

            }

        }



        if($this->sortBy == $orderField )

        {

            $imgStr = '<img src="'.$this->arrow.'" alt="Sorted in : '.$this->orderBy.'ENDING order" title="Sorted in : '.$this->orderBy.'ENDING order" style="float:left; margin-top:5px; padding-left:10px;" />';

        }

        else if($this->sortBy == ' ORDER BY '.$orderField)

        {

            $imgStr = '<img src="'.$this->arrow.'" alt="Sorted in : '.$this->orderBy.'ENDING order" title="Sorted in : '.$this->orderBy.'ENDING order" style="float:left; margin-top:5px; padding-left:10px;" />';

        }

        else

        {

            $imgStr = '';

        }



        if($URL=='no')

        {

    $this->orderEventBlock .= '<td class="bor_bottom" style="color:#FFFFFF; float:left">'.$this->prepend.$orderTitle.$this->append.'</td>';

        }

        else

        {

            if($orderField == 'PageStatus' || $orderField == 'BlogStatus' || $orderField =='NewsletterSubscriberStatus')

            {

                $this->orderEventBlock .= '<td class="bor_bottom" ><strong style="float:left;">'.$this->prepend.'<a title="Sort this column in '.$orderBy.'ENDING order" href="'.$URL.'?sortBy='.$orderField.'&amp;orderBy='.$orderBy.$this->extra.'" style="color:#FFFFFF">'.$orderTitle.'</a></strong>'.$imgStr.$this->append.'</td>';

            }

            else

            {

                $this->orderEventBlock .= '<td class="bor_bottom" ><strong style="float:left;">'.$this->prepend.'<a title="Sort this column in '.$orderBy.'ENDING order" style="color:#FFFFFF" href="'.$URL.'?sortBy='.$orderField.'&amp;orderBy='.$orderBy.$this->extra.'">'.$orderTitle.'</a></strong>'.$imgStr.$this->append.'</td>';

            }

        }

    }
	/** 
	*
	* Function name : orderEventOptions
	*
	* Return type : String
	*
	* Date created : 20th July 2013
	*
	* Date last modified : 20th July 2013
	*
	* Author : Rupesh Parmar
	*
	* Last modified by : Rupesh Parmar
	*
	* Comments : Function will return the order by clause
	*
	* User instruction : $objOrder->orderEventOptions()
	*
	*/ 

    function orderEventOptions()

    {

        return $this->orderEventBlock;

    }

	/** 
	*
	* Function name : orderBlock
	*
	* Return type : String
	*
	* Date created : 20th July 2013
	*
	* Date last modified : 20th July 2013
	*
	* Author : Rupesh Parmar
	*
	* Last modified by : Rupesh Parmar
	*
	* Comments : Function will return the column title with the link
	*
	* User instruction : $objOrder->orderBlock()
	*
	*/ 

    function orderEventBlock()

    {

        return $this->orderEventBlock;

    }

}

?>
