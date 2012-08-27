/*
 *Note: unlike other js files this should not be renamed... privateheader specifically tests for this filename
 * to include a ref to the google js charts api in the head
 */
function Start_Sitestats(){
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawSiteStats);
}

function drawSiteStats() {
 
    var data = new google.visualization.DataTable(chartdata);
    /*
    var data = new google.visualization.arrayToDataTable(chartdata);
    */
    var options = {
            title:title,
            height:700,
            chartArea:{left:80,top:20,width:"80%",height:630},
            vAxes:[{gridlines:{color: '#bbb', count: 21}}],
            series:[{color: 'blue', visibleInLegend: true},
                    {color: 'orange', visibleInLegend: true}, 
                    {color: 'green', visibleInLegend: true}, 
                    {color: 'red', visibleInLegend: true}],
            tooltip:{ showColorCode: true},
            hAxis:{slantedText:false,maxTextLines:1,maxAlternation:1}
        }; 

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}
 




