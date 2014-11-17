obj = new Object()

google.load('visualization', '1', {packages:['table']});
google.load('visualization', '1', {'packages':['corechart']});
   
function MakeThousandView(str) {
	str = str.replace(/\s+/g,'');
	return str.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
}
    
function getSum(data, column) {
    var total = 0;
    for (i = 0; i < data.getNumberOfRows(); i++) {
        total = total + data.getValue(i, column);    
    }
    return MakeThousandView(total.toFixed(2));
}

function drawTable(json_table, array_option) {
    var data = new google.visualization.DataTable(json_table);
    var table = new google.visualization.Table(document.getElementById('table_div'));
    var options = {
            allowHtml: true,
            showRowNumber: array_option[3]
        }
    var formatter = new google.visualization.NumberFormat(
    {decimalSymbol: '.', negativeColor: 'red'});
    switch(array_option[4]) {
        case(0):
            formatter.format(data, array_option[2]);  
            formatter.format(data, array_option[2]+1);
            formatter.format(data, array_option[2]+2);
            formatter.format(data, array_option[2]+3);
            formatter.format(data, array_option[2]+4);
            
            data.setColumnLabel(array_option[2],   'Entrepreneur1, €  (' + getSum(data, array_option[2]) + ')');
            data.setColumnLabel(array_option[2]+1, 'Entrepreneur2, € (' + getSum(data, array_option[2]+1) + ')');
            data.setColumnLabel(array_option[2]+2, 'Entrepreneur3, € (' + getSum(data, array_option[2]+2) + ')');
            data.setColumnLabel(array_option[2]+3, 'Entrepreneur4, € (' + getSum(data, array_option[2]+3) + ')');
            data.setColumnLabel(array_option[2]+4, 'Sum, € (' + getSum(data, array_option[2]+4) + ')');    
            break;
        case(1):
            formatter.format(data, array_option[2]);
            data.setColumnLabel(array_option[2], 'Sum, € (' + getSum(data, array_option[2]) + ')');
            break;
        case(2):
            formatter.format(data, array_option[2]);  
            formatter.format(data, array_option[2]+1);
            formatter.format(data, array_option[2]+2);
            formatter.format(data, array_option[2]+3);
            
            data.setColumnLabel(array_option[2],'Entrepreneur1, € (' + getSum(data, array_option[2]) + ')');
            data.setColumnLabel(array_option[2]+1,'Entrepreneur2, € (' + getSum(data, array_option[2]+1) + ')');
            data.setColumnLabel(array_option[2]+2,'Entrepreneur3, € (' + getSum(data, array_option[2]+2) + ')');
            data.setColumnLabel(array_option[2]+3,'Sum, € (' + getSum(data, array_option[2]+3) + ')');    
            break;      
    }
    table.draw(data, options);
}

function drawChart(json_graph, array_option) {
    var data = new google.visualization.DataTable(json_graph);
    var options = {
        title: array_option[0],
        pointSize: 3,
        height: 450,
        fontSize: 11,
        hAxis: {title: 'Time (week)'},
        vAxis: {title: 'Sum, ' + array_option[1]},
        legend: { position: 'bottom' }
    }
    
    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}

function runajaxsale() {
    var button = true;
    var controller = $("#controller").val();
    var array_option = [];
    switch (controller) {
        case ('Remain'):
            array_option.push('Balances');
            array_option.push('€');
            array_option.push(1);
            array_option.push(true);
            array_option.push(2);
            break;
        case ('Sale'):
            array_option.push('Sale');
            array_option.push('€');
            array_option.push(1);
            array_option.push(true);
            array_option.push(0);
            break;
        case ('Money'):
            array_option.push('Funds');
            array_option.push('€');
            array_option.push(0);
            array_option.push(false);
            array_option.push(0);
            break;
        case ('Costs'):
            array_option.push('Costs');
            array_option.push('€');
            array_option.push(2);
            array_option.push(true);
            array_option.push(1);
            break;
    }
    var date_from = $("#datepickerFrom").val();
    var date_to = $("#datepickerTo").val();
    var array_error = [];
    
    var store_city_sum = $('#store_city_sum').prop('checked');
    var company_sum = $('#company_sum').prop('checked');
    var store_city_id = [];
    $("#store_city_id:checked").each(function() {
        store_city_id.push(this.value);
    });
    
    var company_id = [];
    $("#company_id:checked").each(function() {
        company_id.push(this.value);
    });
    
    $(document).ajaxStart(function(){
        $("#wait").css("display","block");
        $("#error").css("display","none");
        $("#chart_div").empty();
        $("#table_div").empty();
        $("#description").empty();
    });
    
    $.ajax({
        type: "POST",
        url: "/ajax/" + controller.toLowerCase(),
        data: 'date_from=' + date_from + '&date_to=' + date_to + '&store_city_id=' + store_city_id.join() + '&company_id=' + company_id.join() + '&store_city_sum=' + store_city_sum + '&company_sum=' + company_sum + '&button=' + button,
        dataType: "json",
        success: function(data) {
            var array_error = data['data3']; 
            if (array_error.length == 0) {
                obj.data2_count = data['data2_count'];
                $("#wait").css("display","none");
                $(document).ready(drawChart(data['data'], array_option));
                $("#description").empty();
                $("#description").append(data['data1']);
                $(document).ready(drawTable(data['data2'], array_option));
            } else {
                $("#wait").css("display","none");
                $("#error").css("display","block");
                $("#error").empty();
                $("#error").append(array_error); 
            } 
        }
    })
    
    $(document).ajaxError(function(event, XMLHttpRequest, ajaxOptions, thrownError){
        alert(thrownError);
    });
    /*$(document).ajaxStop(function(){
        var self_promise;
        if (controller == 'Costs') {
            for(i=1; i<=obj.data2_count; i++) {
                self_promise = 'self_promise' + i;
                
                $(document).ready(make_tree_menu(self_promise));
                $('#'+self_promise+'li').removeClass('open');
                $('#'+self_promise+'li').removeClass('last');
            }
        }
    });*/
}
	 
$(document).ready(function(){
    $("#ajax").click(runajaxsale);
});

google.setOnLoadCallback(runajaxsale);