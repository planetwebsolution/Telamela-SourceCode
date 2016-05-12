/*jQuery time*/
$(document).ready(function(){
    $("#accordian h3").click(function(){
        //slide up all the link lists
        $("#accordian ul ul").slideUp();
        $("#accordian ul .right-menu-arrows").hide();
        //slide down the link list below the h3 clicked - only if its closed
        if(!$(this).next().is(":visible"))
        {
            $(this).next().next().show();
            $(this).next().slideDown();
                       
        }
    })
})
