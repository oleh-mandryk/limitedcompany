function setChecked(obj, item) {
    switch(item) {
        case (1):
            var check = document.getElementsByName('store_city[]');
            var check_all = document.getElementsByName('store_city_all');
            var check_sum = document.getElementsByName('store_city_sum');
            var check_revers = document.getElementsByName('company[]');
            var check_all_revers = document.getElementsByName('company_all');
            var check_sum_revers = document.getElementsByName('company_sum');
            break;
        case (2):
            var check = document.getElementsByName('company[]');
            var check_all = document.getElementsByName('company_all');
            var check_sum = document.getElementsByName('company_sum');
            var check_revers = document.getElementsByName('store_city[]');
            var check_all_revers = document.getElementsByName('store_city_all');
            var check_sum_revers = document.getElementsByName('store_city_sum');
            break
    }
    checkedAllControl(check, check_all);
    checked_array = checkChecked(check);
    checked_array_revers = checkChecked(check_revers);
    //alert(checked_array[0]);
    //alert(checked_array[1]);
    //alert(checked_array_revers[0]);
    //alert(checked_array_revers[1]);
    if (!check_sum_revers[0].checked) {
        if (checked_array_revers[0] == 1 && checked_array[0] > 1) {
            //alert(1);
            disabledControl2(check_revers, obj, true);
            disabledControlAll(check_all_revers, obj, true);
        } else if (checked_array_revers[0] > 1 && checked_array[0] == 1) {
            //alert (2);
            disabledControl1(check, obj, true);
            disabledControlAll(check_all, obj, true);  
        } else if (checked_array_revers[0] == 1 && checked_array[0] == 1) {
            //alert(11);
            disabledControl2(check_revers, obj, false);
            disabledControlAll(check_all_revers, obj, false);
        } else if (checked_array_revers[0] > 1 && checked_array[0] < 1) {
            //alert (22);
            disabledControl1(check, obj, false);
            //disabledControlAll(check_all, obj, false);   
        } else if (checked_array_revers[0] < 1 && checked_array[0] > 1) {
            //alert (3);
            disabledControlAll(check_all_revers, obj, true);   
        } else if (checked_array_revers[0] < 1 && checked_array[0] <= 1) {
            //alert (33);
            disabledControlAll(check_all_revers, obj, false);   
        }
    } else {
         //alert (4);    
    }
}

function setAll(obj, item) {
    switch(item) {
        case (1):
            var check = document.getElementsByName('store_city[]');
            var check_all = document.getElementsByName('store_city_all');
            var check_sum = document.getElementsByName('store_city_sum');
            var check_revers = document.getElementsByName('company[]');
            var check_all_revers = document.getElementsByName('company_all');
            var check_sum_revers = document.getElementsByName('company_sum');
            break;
        case (2):
            var check = document.getElementsByName('company[]');
            var check_all = document.getElementsByName('company_all');
            var check_sum = document.getElementsByName('company_sum');
            var check_revers = document.getElementsByName('store_city[]');
            var check_all_revers = document.getElementsByName('store_city_all');
            var check_sum_revers = document.getElementsByName('store_city_sum');
            break
    }
    var len = check.length;
    for (var i=0; i<len; i++) {
        check[i].checked = obj.checked;
    }
    checked_array_revers = checkChecked(check_revers);
    checked_array = checkChecked(check);
    if (!check_sum_revers[0].checked) {
        check_all_revers[0].disabled = obj.checked;   
    }
    if (checked_array[0] < 1) {
        disabledControl2(check_revers, obj, false);
        if (!check_sum_revers) {
            disabledControlAll(check_all_revers, obj, false);     
        }
    }
    if (!check_sum[0].checked && checked_array[0] > 1 && checked_array_revers[0] == 1) {
        disabledControl2(check_revers, obj, true);    
    }
}

function setSum(obj, item) {
    switch(item) {
        case(1):
            var check = document.getElementsByName('store_city[]');
            var check_all = document.getElementsByName('store_city_all');
            var check_sum = document.getElementsByName('store_city_sum');
            var check_revers = document.getElementsByName('company[]');
            var check_all_revers = document.getElementsByName('company_all');
            var check_sum_revers = document.getElementsByName('company_sum');
            break;
        case(2):
            var check = document.getElementsByName('company[]');
            var check_all = document.getElementsByName('company_all');
            var check_sum = document.getElementsByName('company_sum');
            var check_revers = document.getElementsByName('store_city[]');
            var check_all_revers = document.getElementsByName('store_city_all');
            var check_sum_revers = document.getElementsByName('store_city_sum');
            break;
    }
    for (var i = 0; i < check.length; i ++) {
        check[i].disabled = obj.checked;
        check[i].checked = obj.checked;
    }
    check_all[0].checked = obj.checked;
    checked_array_revers = checkChecked(check_revers);
    if (!check_sum_revers[0].checked && checked_array_revers[0] > 1) {
        check_all[0].disabled = true;      
    } else {
        check_all[0].disabled = obj.checked;
    }
    
    if (!check_sum_revers[0].checked && checked_array_revers[0] <= 1) {
        //alert(6);
        disabledControl2(check_revers, obj, false);
        disabledControlAll(check_all_revers, obj, false); 
    }
}

function setMoneySum(obj) {
    var check = document.getElementsByName('company[]');
    var check_all = document.getElementsByName('company_all');
    for (var i = 0; i < check.length; i ++) {
        check[i].disabled = obj.checked;
        check[i].checked = obj.checked;
    }
    check_all[0].checked = obj.checked;
    check_all[0].disabled = obj.checked;
}

//якщо всі чекбокси вибрані тоді проставляється чекбокс всі
function checkedAllControl(check, check_all) {
    j=0;
    var len = check.length;
    for (var i=0; i<check.length; i++) {
        if (check[i].checked == true) {
            j++;
        }
    }
    if (len==j) {
        check_all[0].checked = true;
    } else {
        check_all[0].checked = false;      
    }    
}

//повертає масив з кількістю виділених чекбоксів і загальною кількістю чекбоксів
function checkChecked(check) {
    k=0;
    for (var i=0; i<check.length; i++) {
        if (check[i].checked == true) {
            k++;
        }
    }
    return array = [k, check.length];   
}

function disabledControl1(check, obj, value) {
    for (var i=0; i<check.length; i++) {
        if (check[i].value != obj.value) {
            check[i].disabled = value;
        }
    } 
}

function disabledControlAll(check_all, obj, value) {
    check_all[0].disabled = value;    
}

function disabledControl2(check, obj, value) {
    for (var i=0; i<check.length; i++) {
        if (!check[i].checked) {
            check[i].disabled = value;
        }
    } 
}