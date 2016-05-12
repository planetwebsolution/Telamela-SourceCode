$(function(){
    
    
    
    $('.tabAjaxChange').on('click',function(){
        
        var htmlContainerID=$(this).data('container');
        var parentSection=$(this).data('section');
        var subAction=$(this).data('action');
        //alert("htmlContainerID="+htmlContainerID+" || section="+parentSection+" || action="+subAction);
        $('.loader-holder').show();
        var urlToHit="ajax_orders.php";
        
        $.post(urlToHit,{
            section:parentSection,
            action:subAction,            
        },
        function(data)
        {
            //alert(parentSection);
            if (parentSection=="orders") {
                if (subAction=="today" || subAction=="yesterday") {
                    var result=$.parseJSON(data);               
                    //console.log(result);
                    var arrData=[];
                    var arrGraphCordinates=[];
                    $.each(result.data, function(index, obj){                    
                        if (obj.time !='') {
                            $.each(obj.time[0], function(indexTime, objTime){
                                //console.log(indexTime+'###############'+objTime.date);
                                var resArray = objTime.date.split(":");                            
                                var objectUSed=resArray[0];
                                
                                objectUSed=objectUSed.replace(/^0+/, '');
                                
                                //alert(objectUSed);
                                if (objectUSed in arrData){
                                    //alert("defined");
                                    arrData[objectUSed]['count']=arrData[objectUSed]['count']+1;
                                }else{
                                    //alert("not defined");
                                    arrData[objectUSed]=[];
                                    arrData[objectUSed]['count']=1;
                                }
                            });
                        }else{
                            
                        }
                    });
                    //console.log(arrData);
                    var count=0;
                    $.each(arrData, function(arrDataIndex, arrDatVal){
                        if (arrDatVal  != undefined) {
                            arrSarrStore=[];                     
                            
                            arrSarrStore.push(arrDataIndex);
                            arrSarrStore.push(arrDatVal['count']);
                            
                            
                            arrGraphCordinates.push(arrSarrStore);
                            
                            count++;
                        }
                        //else{
                        //    arrSarrStore=[];
                        //    arrSarrStore.push(arrDataIndex);
                        //    arrSarrStore.push(0);
                        //    arrGraphCordinates.push(arrSarrStore);
                        //}
                        
                    });
                    
                    //console.log(arrGraphCordinates);
                    $("#flot-audience-"+subAction).empty();
                    $(".totalCount").empty().html(result.total);
                    if($("#flot-audience-"+subAction).length > 0){
                        
                        //var data = [[5,1], [7,2], [13,1]];
                        console.log(data);
                        $.plot($("#flot-audience-"+subAction), [{ 
                                label: "Quantity", 
                                data: arrGraphCordinates,
                                color: "#3a8ce5"
                        }], {
                            xaxis: {
                                    min: 0,
                                    max: 24,
                                    mode: null,
                                    tickSize: 4,
                                    tickDecimals:null,
                            },
                            yaxis: {
                                    min: 0,
                                    max: 100,
                                    mode: "null",
                                    tickSize: 5,
                                    tickDecimals:null,
                            },
                            series: {
                                    lines: {
                                            show: true, 
                                            fill: true
                                    },
                                    points: {
                                            show: true,
                                    }
                            },
                            grid: { hoverable: true, clickable: true },
                            legend: {
                                    show: true
                            }
                        });
                    }
                    
                    $("#flot-audience-"+subAction).bind("plothover", function (event, pos, item) {
                        if (item) {
                                if (previousPoint != item.dataIndex) {
                                        previousPoint = item.dataIndex;
            
                                        $("#tooltip").remove();
                                        var y = item.datapoint[1].toFixed();
            
                                        showTooltip(item.pageX, item.pageY,
                                                    item.series.label + " = " + y);
                                }
                        }
                        else {
                                $("#tooltip").remove();
                                previousPoint = null;            
                        }
                    });
                    
                    var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("Hours").appendTo($("#flot-audience-"+subAction));

                    var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("Quantity").appendTo($("#flot-audience-"+subAction));
                    yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);
                }
                
                else if (subAction=="last_week") {
                    var result=$.parseJSON(data);               
                    //console.log(result);
                    var arrData=[];
                    var arrGraphCordinates=[];
                    $.each(result.data, function(index, obj){
                        console.log(obj.count);
                        arrSarrStore=[];                    
                            
                        arrSarrStore.push(index);
                        arrSarrStore.push(obj.count);
                        arrGraphCordinates.push(arrSarrStore);
                    });
                    //console.log(arrGraphCordinates);
                    $("#flot-audience-"+subAction).empty();
                    $(".totalCount").empty().html(result.total);
                    if($("#flot-audience-"+subAction).length > 0){
                        
                        //var data = [[1,10],[5,1], [7,25] ];
                        var data = arrGraphCordinates;
                        //console.log(data);
                        $.plot($("#flot-audience-"+subAction), [{ 
                                label: "Quantity", 
                                data: data,
                                color: "#3a8ce5"
                        }], {
                            xaxis: {
                                min: 0,
                                max: 6,
                                //ticks: [[1,"Sun"], [2,"Mon"], [3,"Tue"], [4,"Wed"], [5,"Thu"],[6,"Fri"],[7,"Sat"]],
                                ticks: [[0,"Sun"], [1,"Mon"], [2,"Tue"], [3,"Wed"], [4,"Thu"],[5,"Fri"],[6,"Sat"]],
                            },
                            yaxis: {
                                    min: 0,
                                    max: 100,
                                    mode: "null",
                                    tickSize: 5,
                                    tickDecimals:null,
                            },
                            series: {
                                    lines: {
                                            show: true, 
                                            fill: true
                                    },
                                    points: {
                                            show: true,
                                    }
                            },
                            grid: { hoverable: true, clickable: true },
                            legend: {
                                    show: true
                            }
                        });
                    }
                    
                    $("#flot-audience-"+subAction).bind("plothover", function (event, pos, item) {
                        if (item) {
                                if (previousPoint != item.dataIndex) {
                                        previousPoint = item.dataIndex;
            
                                        $("#tooltip").remove();
                                        var y = item.datapoint[1].toFixed();
            
                                        showTooltip(item.pageX, item.pageY,
                                                    item.series.label + " = " + y);
                                }
                        }
                        else {
                                $("#tooltip").remove();
                                previousPoint = null;            
                        }
                    });
                    var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("Days").appendTo($("#flot-audience-"+subAction));

                    var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("Quantity").appendTo($("#flot-audience-"+subAction));
                    yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);
                }
                
                else if (subAction=="last_month") {
                    var result=$.parseJSON(data);               
                    //console.log(result);
                    var arrData=[];
                    var arrGraphCordinates=[];
                    var arrGraphYAxis=[];
                    $.each(result.data, function(index, obj){
                        //console.log(obj.count);
                        arrSarrStore=[];                    
                            
                        arrSarrStore.push(index);
                        arrSarrStore.push(obj.count);
                        arrGraphCordinates.push(arrSarrStore);
                    });
                    var maxLength=arrGraphCordinates.length;
                    
                    for(x=0;x<=maxLength;x++){
                        arrSarrStore1=[];                    
                            
                        arrSarrStore1.push(x);
                        arrSarrStore1.push(x+" week(s)");
                        arrGraphYAxis.push(arrSarrStore1);
                    }
                    
                    //console.log(arrGraphCordinates);
                    //console.log(arrGraphYAxis);
                    $("#flot-audience-"+subAction).empty();
                    $(".totalCount").empty().html(result.total);
                    
                    if($("#flot-audience-"+subAction).length > 0){                    
                        //var data = [[1,10],[5,1], [7,25] ];
                        var data = arrGraphCordinates;
                        //console.log(data);
                        $.plot($("#flot-audience-"+subAction), [{ 
                                label: "Quantity", 
                                data: data,
                                color: "#3a8ce5"
                        }], {
                            xaxis: {
                                min: 1,
                                max: maxLength,
                                //ticks: [[1,"Sun"], [2,"Mon"], [3,"Tue"], [4,"Wed"], [5,"Thu"],[6,"Fri"],[7,"Sat"]],
                                ticks: arrGraphYAxis,
                            },
                            yaxis: {
                                    min: 0,
                                    max: 100,
                                    mode: "null",
                                    tickSize: 5,
                                    tickDecimals:null,
                            },
                            series: {
                                    lines: {
                                            show: true, 
                                            fill: true
                                    },
                                    points: {
                                            show: true,
                                    }
                            },
                            grid: { hoverable: true, clickable: true },
                            legend: {
                                    show: true
                            }
                        });
                    }
                    
                    $("#flot-audience-"+subAction).bind("plothover", function (event, pos, item) {
                        if (item) {
                                if (previousPoint != item.dataIndex) {
                                        previousPoint = item.dataIndex;
            
                                        $("#tooltip").remove();
                                        var y = item.datapoint[1].toFixed();
            
                                        showTooltip(item.pageX, item.pageY,
                                                    item.series.label + " = " + y);
                                }
                        }
                        else {
                                $("#tooltip").remove();
                                previousPoint = null;            
                        }
                    });
                    var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("Weeks").appendTo($("#flot-audience-"+subAction));

                    var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("Quantity").appendTo($("#flot-audience-"+subAction));
                    yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);
                }
                
                else if (subAction=="top_order") {
                    var resData=$.parseJSON(data);               
                    //console.log(resData.result);
                    var html='';
                    if (resData.count>0) {
                        html='<table class="table table-hover table-nomargin table-bordered">';
                        html +='<thead>';
                        html +='<tr>';
                        html +='<th align="center">Product ID</th>';
                        html +='<th align="center">Category</th>';
                        html +='<th align="center">Product Name</th>';
                        html +='<th align="center">Product Wholesaler Price</th>';
                        html +='<th align="center">No. of times ordered</th>';
                        html +='</tr>';
                        html +='</thead>';
                        html +='<tbody>';
                        
                        $.each(resData.result, function(index, obj){
                            if (obj.wholesalePrice!='') {
                                obj.wholesalePrice='$'+obj.wholesalePrice;
                            }
                            html +='<tr>';
                            html +='<td align="center">'+obj.fkItemID+'</td>';
                            html +='<td align="center">'+obj.CategoryHierarchy+'</td>';
                            html +='<td align="center">'+obj.ItemName+'</td>';
                            html +='<td align="center">'+obj.wholesalePrice+'</td>';
                            html +='<td align="center">'+obj.count+'</td>';       
                            html +='</tr>';
                        });
                        
                        html +='</tbody>';
                        html +='</table>';
                    }else{
                        html='<span class="noResults">Sorry No results found!</span>';
                    }
                    $('#orderTopContainer').html(html);
                    
                }                        
                
            }else if (parentSection=='revenue') {
                //alert(subAction);
                if (subAction=="daily" || subAction=="yesterday") {
                    var result=$.parseJSON(data);               
                    //console.log(result);
                    var arrData=[];
                    var arrGraphCordinates=[];
                    $.each(result.data, function(index, obj){                    
                        if (obj.time !='') {
                            $.each(obj.time, function(indexTime, objTime){
                                //console.log(indexTime+'###############'+objTime.date);
                                var resArray = objTime.date.split(":");                            
                                var objectUSed=resArray[0];
                                
                                objectUSed=objectUSed.replace(/^0+/, '');
                                
                                //alert(objectUSed);
                                if (objectUSed in arrData){
                                    //alert("defined");
                                    arrData[objectUSed]['count']=obj.count;
                                }else{
                                    //alert("not defined");
                                    arrData[objectUSed]=[];
                                    arrData[objectUSed]['count']=obj.count
                                }
                            });
                        }else{
                            
                        }
                    });
                    //console.log(arrData);
                    var count=0;
                    $.each(arrData, function(arrDataIndex, arrDatVal){
                        if (arrDatVal  != undefined) {
                            arrSarrStore=[];                     
                            
                            arrSarrStore.push(arrDataIndex);
                            arrSarrStore.push(arrDatVal['count']);
                            
                            
                            arrGraphCordinates.push(arrSarrStore);
                            
                            count++;
                        }
                        //else{
                        //    arrSarrStore=[];
                        //    arrSarrStore.push(arrDataIndex);
                        //    arrSarrStore.push(0);
                        //    arrGraphCordinates.push(arrSarrStore);
                        //}
                        
                    });
                    
                    //console.log(arrGraphCordinates);
                    $("#flot-audience-"+subAction).empty();
                    $(".totalCount").empty().html('$'+result.total);
                    if($("#flot-audience-"+subAction).length > 0){
                        
                        //var data = [[5,1], [7,2], [13,1]];
                        console.log(data);
                        $.plot($("#flot-audience-"+subAction), [{ 
                                label: "Revenue($)", 
                                data: arrGraphCordinates,
                                color: "#3a8ce5"
                        }], {
                            xaxis: {
                                    min: 0,
                                    max: 24,
                                    mode: null,
                                    tickSize: 4,
                                    tickDecimals:null,
                            },
                            yaxis: {
                                    min: 0,
                                    max: 10000,
                                    mode: "null",
                                    tickSize: 500,
                                    tickDecimals:null,
                            },
                            series: {
                                    lines: {
                                            show: true, 
                                            fill: true
                                    },
                                    points: {
                                            show: true,
                                    }
                            },
                            grid: { hoverable: true, clickable: true },
                            legend: {
                                    show: true
                            }
                        });
                    }
                    
                    $("#flot-audience-"+subAction).bind("plothover", function (event, pos, item) {
                        if (item) {
                                if (previousPoint != item.dataIndex) {
                                        previousPoint = item.dataIndex;
            
                                        $("#tooltip").remove();
                                        var y = item.datapoint[1].toFixed();
            
                                        showTooltip(item.pageX, item.pageY,
                                                    item.series.label + " = " + y);
                                }
                        }
                        else {
                                $("#tooltip").remove();
                                previousPoint = null;            
                        }
                    });
                    var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("Hours").appendTo($("#flot-audience-"+subAction));

                    var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("Revenue ($)").appendTo($("#flot-audience-"+subAction));
                    yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);
                } else if (subAction=="weekly") {
                    var result=$.parseJSON(data);               
                    console.log(result);
                    var arrData=[];
                    var arrGraphCordinates=[];
                    $.each(result.data, function(index, obj){
                        console.log(obj.count);
                        arrSarrStore=[];                    
                            
                        arrSarrStore.push(index);
                        arrSarrStore.push(obj.count);
                        arrGraphCordinates.push(arrSarrStore);
                    });
                    //console.log(arrGraphCordinates);
                    $("#flot-audience-"+subAction).empty();
                    $(".totalCount").empty().html('$'+result.total);
                    if($("#flot-audience-"+subAction).length > 0){
                        
                        //var data = [[1,10],[5,1], [7,25] ];
                        var data = arrGraphCordinates;
                        //console.log(data);
                        $.plot($("#flot-audience-"+subAction), [{ 
                                label: "Revenue($)", 
                                data: data,
                                color: "#3a8ce5"
                        }], {
                            xaxis: {
                                min: 0,
                                max: 6,
                                //ticks: [[1,"Sun"], [2,"Mon"], [3,"Tue"], [4,"Wed"], [5,"Thu"],[6,"Fri"],[7,"Sat"]],
                                ticks: [[0,"Sun"], [1,"Mon"], [2,"Tue"], [3,"Wed"], [4,"Thu"],[5,"Fri"],[6,"Sat"]],
                            },
                            yaxis: {
                                    min: 0,
                                    max: 100,
                                    mode: "null",
                                    tickSize: 5,
                                    tickDecimals:null,
                            },
                            series: {
                                    lines: {
                                            show: true, 
                                            fill: true
                                    },
                                    points: {
                                            show: true,
                                    }
                            },
                            grid: { hoverable: true, clickable: true },
                            legend: {
                                    show: true
                            }
                        });
                    }
                    
                    $("#flot-audience-"+subAction).bind("plothover", function (event, pos, item) {
                        if (item) {
                                if (previousPoint != item.dataIndex) {
                                        previousPoint = item.dataIndex;
            
                                        $("#tooltip").remove();
                                        var y = item.datapoint[1].toFixed();
            
                                        showTooltip(item.pageX, item.pageY,
                                                    item.series.label + " = " + y);
                                }
                        }
                        else {
                                $("#tooltip").remove();
                                previousPoint = null;            
                        }
                    });
                    
                    var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("Days").appendTo($("#flot-audience-"+subAction));

                    var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("Revenue ($)").appendTo($("#flot-audience-"+subAction));
                    yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);
                } else if (subAction=="monthly") {
                    var result=$.parseJSON(data);               
                    //console.log(result);
                    var arrData=[];
                    var arrGraphCordinates=[];
                    var arrGraphYAxis=[];
                    $.each(result.data, function(index, obj){
                        console.log(obj.count);
                        arrSarrStore=[];                    
                            
                        arrSarrStore.push(index);
                        arrSarrStore.push(obj.count);
                        arrGraphCordinates.push(arrSarrStore);
                    });
                    var maxLength=arrGraphCordinates.length;
                    
                    for(x=0;x<=maxLength;x++){
                        arrSarrStore1=[];                    
                            
                        arrSarrStore1.push(x);
                        arrSarrStore1.push(x+" week(s)");
                        arrGraphYAxis.push(arrSarrStore1);
                    }
                    
                    //console.log(arrGraphCordinates);
                    //console.log(arrGraphYAxis);
                    $("#flot-audience-"+subAction).empty();
                    $(".totalCount").empty().html('$'+result.total);
                    
                    if($("#flot-audience-"+subAction).length > 0){                    
                        //var data = [[1,10],[5,1], [7,25] ];
                        var data = arrGraphCordinates;
                        //console.log(data);
                        $.plot($("#flot-audience-"+subAction), [{ 
                                label: "Revenue($)", 
                                data: data,
                                color: "#3a8ce5"
                        }], {
                            xaxis: {
                                min: 1,
                                max: maxLength,
                                //ticks: [[1,"Sun"], [2,"Mon"], [3,"Tue"], [4,"Wed"], [5,"Thu"],[6,"Fri"],[7,"Sat"]],
                                ticks: arrGraphYAxis,
                            },
                            yaxis: {
                                    min: 0,
                                    max: 10000,
                                    mode: "null",
                                    tickSize: 500,
                                    tickDecimals:null,
                            },
                            series: {
                                    lines: {
                                            show: true, 
                                            fill: true
                                    },
                                    points: {
                                            show: true,
                                    }
                            },
                            grid: { hoverable: true, clickable: true },
                            legend: {
                                    show: true
                            }
                        });
                    }
                    
                    $("#flot-audience-"+subAction).bind("plothover", function (event, pos, item) {
                        if (item) {
                                if (previousPoint != item.dataIndex) {
                                        previousPoint = item.dataIndex;
            
                                        $("#tooltip").remove();
                                        var y = item.datapoint[1].toFixed();
            
                                        showTooltip(item.pageX, item.pageY,
                                                    item.series.label + " = " + y);
                                }
                        }
                        else {
                                $("#tooltip").remove();
                                previousPoint = null;            
                        }
                    });
                    var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("Weeks").appendTo($("#flot-audience-"+subAction));

                    var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("Revenue ($)").appendTo($("#flot-audience-"+subAction));
                    yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);
                }
            }if (parentSection=="sales") {
                if (subAction=="today" || subAction=="yesterday") {
                    var result=$.parseJSON(data);               
                    //console.log(result);
                    var arrData=[];
                    var arrGraphCordinates=[];
                    $.each(result.data, function(index, obj){                    
                        if (obj.time !='') {
                            $.each(obj.time, function(indexTime, objTime){
                                //console.log(indexTime+'###############'+objTime.date);
                                var resArray = objTime.date.split(":");                            
                                var objectUSed=resArray[0];
                                
                                objectUSed=objectUSed.replace(/^0+/, '');
                                
                                //alert(objectUSed);
                                if (objectUSed in arrData){
                                    //alert("defined");
                                    arrData[objectUSed]['count']=obj.count;
                                }else{
                                    //alert("not defined");
                                    arrData[objectUSed]=[];
                                    arrData[objectUSed]['count']=obj.count
                                }
                            });
                        }else{
                            
                        }
                    });
                    //console.log(arrData);
                    var count=0;
                    $.each(arrData, function(arrDataIndex, arrDatVal){
                        if (arrDatVal  != undefined) {
                            arrSarrStore=[];                     
                            
                            arrSarrStore.push(arrDataIndex);
                            arrSarrStore.push(arrDatVal['count']);
                            
                            
                            arrGraphCordinates.push(arrSarrStore);
                            
                            count++;
                        }
                        //else{
                        //    arrSarrStore=[];
                        //    arrSarrStore.push(arrDataIndex);
                        //    arrSarrStore.push(0);
                        //    arrGraphCordinates.push(arrSarrStore);
                        //}
                        
                    });
                    
                    //console.log(arrGraphCordinates);
                    $("#flot-audience-"+subAction).empty();
                    $(".totalCount").empty().html('$'+result.total);
                    if($("#flot-audience-"+subAction).length > 0){
                        
                        //var data = [[5,1], [7,2], [13,1]];
                        console.log(data);
                        $.plot($("#flot-audience-"+subAction), [{ 
                                label: "Sale($)", 
                                data: arrGraphCordinates,
                                color: "#3a8ce5"
                        }], {
                            xaxis: {
                                    min: 0,
                                    max: 24,
                                    mode: null,
                                    tickSize: 4,
                                    tickDecimals:null,
                            },
                            yaxis: {
                                    min: 0,
                                    max: 10000,
                                    mode: "null",
                                    tickSize: 500,
                                    tickDecimals:null,
                            },
                            series: {
                                    lines: {
                                            show: true, 
                                            fill: true
                                    },
                                    points: {
                                            show: true,
                                    }
                            },
                            grid: { hoverable: true, clickable: true },
                            legend: {
                                    show: true
                            }
                        });
                    }
                    
                    $("#flot-audience-"+subAction).bind("plothover", function (event, pos, item) {
                        if (item) {
                                if (previousPoint != item.dataIndex) {
                                        previousPoint = item.dataIndex;
            
                                        $("#tooltip").remove();
                                        var y = item.datapoint[1].toFixed();
            
                                        showTooltip(item.pageX, item.pageY,
                                                    item.series.label + " = " + y);
                                }
                        }
                        else {
                                $("#tooltip").remove();
                                previousPoint = null;            
                        }
                    });
                    var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("Hours").appendTo($("#flot-audience-"+subAction));

                    var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("Sales ($)").appendTo($("#flot-audience-"+subAction));
                    yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);
                }
                
                else if (subAction=="last_week") {
                    var result=$.parseJSON(data);               
                    //console.log(result);
                    var arrData=[];
                    var arrGraphCordinates=[];
                    $.each(result.data, function(index, obj){
                        //console.log(obj.count);
                        arrSarrStore=[];                    
                            
                        arrSarrStore.push(index);
                        arrSarrStore.push(obj.count);
                        arrGraphCordinates.push(arrSarrStore);
                    });
                    //console.log(arrGraphCordinates);
                    $("#flot-audience-"+subAction).empty();
                    $(".totalCount").empty().html('$'+result.total);
                    if($("#flot-audience-"+subAction).length > 0){
                        
                        //var data = [[1,10],[5,1], [7,25] ];
                        var data = arrGraphCordinates;
                        //console.log(data);
                        $.plot($("#flot-audience-"+subAction), [{ 
                                label: "Sales", 
                                data: data,
                                color: "#3a8ce5"
                        }], {
                            xaxis: {
                                min: 0,
                                max: 6,
                                //ticks: [[1,"Sun"], [2,"Mon"], [3,"Tue"], [4,"Wed"], [5,"Thu"],[6,"Fri"],[7,"Sat"]],
                                ticks: [[0,"Sun"], [1,"Mon"], [2,"Tue"], [3,"Wed"], [4,"Thu"],[5,"Fri"],[6,"Sat"]],
                            },
                            yaxis: {
                                    min: 0,
                                    max: 10000,
                                    mode: "null",
                                    tickSize: 500,
                                    tickDecimals:null,
                            },
                            series: {
                                    lines: {
                                            show: true, 
                                            fill: true
                                    },
                                    points: {
                                            show: true,
                                    }
                            },
                            grid: { hoverable: true, clickable: true },
                            legend: {
                                    show: true
                            }
                        });
                    }
                    
                    $("#flot-audience-"+subAction).bind("plothover", function (event, pos, item) {
                        if (item) {
                                if (previousPoint != item.dataIndex) {
                                        previousPoint = item.dataIndex;
            
                                        $("#tooltip").remove();
                                        var y = item.datapoint[1].toFixed();
            
                                        showTooltip(item.pageX, item.pageY,
                                                    item.series.label + " = " + y);
                                }
                        }
                        else {
                                $("#tooltip").remove();
                                previousPoint = null;            
                        }
                    });
                    var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("Days").appendTo($("#flot-audience-"+subAction));

                    var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("Sales").appendTo($("#flot-audience-"+subAction));
                    yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);
                }
                
                else if (subAction=="last_month") {
                    var result=$.parseJSON(data);               
                    //console.log(result);
                    var arrData=[];
                    var arrGraphCordinates=[];
                    var arrGraphYAxis=[];
                    $.each(result.data, function(index, obj){
                        //console.log(obj.count);
                        arrSarrStore=[];                    
                            
                        arrSarrStore.push(index);
                        arrSarrStore.push(obj.count);
                        arrGraphCordinates.push(arrSarrStore);
                    });
                    var maxLength=arrGraphCordinates.length;
                    
                    for(x=0;x<=maxLength;x++){
                        arrSarrStore1=[];                    
                            
                        arrSarrStore1.push(x);
                        arrSarrStore1.push(x+" week(s)");
                        arrGraphYAxis.push(arrSarrStore1);
                    }
                    
                    //console.log(arrGraphCordinates);
                    //console.log(arrGraphYAxis);
                    $("#flot-audience-"+subAction).empty();
                    $(".totalCount").empty().html(result.total);
                    
                    if($("#flot-audience-"+subAction).length > 0){                    
                        //var data = [[1,10],[5,1], [7,25] ];
                        var data = arrGraphCordinates;
                        //console.log(data);
                        $.plot($("#flot-audience-"+subAction), [{ 
                                label: "Sales ($)", 
                                data: data,
                                color: "#3a8ce5"
                        }], {
                            xaxis: {
                                min: 1,
                                max: maxLength,
                                //ticks: [[1,"Sun"], [2,"Mon"], [3,"Tue"], [4,"Wed"], [5,"Thu"],[6,"Fri"],[7,"Sat"]],
                                ticks: arrGraphYAxis,
                            },
                            yaxis: {
                                    min: 0,
                                    max: 100,
                                    mode: "null",
                                    tickSize: 5,
                                    tickDecimals:null,
                            },
                            series: {
                                    lines: {
                                            show: true, 
                                            fill: true
                                    },
                                    points: {
                                            show: true,
                                    }
                            },
                            grid: { hoverable: true, clickable: true },
                            legend: {
                                    show: true
                            }
                        });
                    }
                    
                    $("#flot-audience-"+subAction).bind("plothover", function (event, pos, item) {
                        if (item) {
                                if (previousPoint != item.dataIndex) {
                                        previousPoint = item.dataIndex;
            
                                        $("#tooltip").remove();
                                        var y = item.datapoint[1].toFixed();
            
                                        showTooltip(item.pageX, item.pageY,
                                                    item.series.label + " = " + y);
                                }
                        }
                        else {
                                $("#tooltip").remove();
                                previousPoint = null;            
                        }
                    });
                    var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("Weeks").appendTo($("#flot-audience-"+subAction));

                    var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("Quantity").appendTo($("#flot-audience-"+subAction));
                    yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);
                }
                
            }
            $('.loader-holder').fadeOut();
        }
        );
        
    });
    
    $('#reportsSearchButton').on("click",function(){
        var dateFromVal=$('#frmDateFrom').val();
        var dateToVal=$('#frmDateTo').val();
        
        if(dateFromVal=="" && dateToVal=="") {
            return false;
        }else{
            $('#srchGraphContainer').empty();
            $('.loader-holder').show();
            var urlToHit="ajax_orders.php";        
            $.post(urlToHit,{
                section:"orders",
                action:"searchReports",
                data:{
                    'fromDate':dateFromVal,
                    'toDate':dateToVal                    
                }
            },
            function(data)
            {
                var dataRes=$.parseJSON(data);               
                //console.log(result);
                $('#srchGraphContainer').html('<h5>Total orders:</h5><span>'+dataRes.result+'</span>')
                $('.loader-holder').fadeOut();
            });
        }
        
    });
});

function visitorsGraph (section,data){
    //console.log(section+'<br>'+data);
    var resData=$.parseJSON(data);
    console.log(resData);
    
    var arrData=[];
    var arrGraphCordinates=[];
    $.each(resData, function(index, obj){
        if (index=='current') {
            $xAxis="1";
        }else{
            $xAxis="0";
        }
        
        arrSarrStore=[];                    
            
        arrSarrStore.push($xAxis);
        arrSarrStore.push(obj.count);
        arrGraphCordinates.push(arrSarrStore);
    });
    console.log(arrGraphCordinates);
    if($("#flot-audience").length > 0){
        
        //var data = [[1,450],[2,180]];
        var data = arrGraphCordinates;
        //console.log(data);
        $.plot($("#flot-audience"), [{ 
                label: "Visitors", 
                data: data,
                color: "#3a8ce5"
        }], {
            xaxis: {
                min: 0,
                max: 1,
                ticks: [[0,"Last Month"], [1,"Current Month"]],
            },
            yaxis: {
                    min: 0,
                    max: 10000,
                    mode: "null",
                    tickSize: 500,
                    tickDecimals:null,
            },
            series: {
                    lines: {
                            show: true, 
                            fill: true
                    },
                    points: {
                            show: true,
                    }
            },
            grid: { hoverable: true, clickable: true },
            legend: {
                    show: true
            }
        });
    }
    
    $("#flot-audience").bind("plothover", function (event, pos, item) {
        if (item) {
                if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var y = item.datapoint[1].toFixed();

                        showTooltip(item.pageX, item.pageY,
                                    item.series.label + " = " + y);
                }
        }
        else {
                $("#tooltip").remove();
                previousPoint = null;            
        }
    });
    
    var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("Months").appendTo($("#flot-audience-"+subAction));

    var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("Visitors").appendTo($("#flot-audience-"+subAction));
    yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);
}