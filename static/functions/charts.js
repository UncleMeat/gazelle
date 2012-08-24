
function Start_GChart(){
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
}

function drawChart() {
    /*
    var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]); 
      title: 'Site stats', 
         */
    var data = new google.visualization.arrayToDataTable(chartdata);
    var options = {
            height:700,
            chartArea:{left:120,top:20,width:"75%",height:600},
            vAxes:[{gridlines:{color: '#bbb', count: 10}}]
        };

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}

addDOMLoadEvent(Start_GChart);




