$(function() {
    $("#datepickerFrom").datepicker({
        showButtonPanel: true,
        changeMonth: true,
        changeYear: true
    });
});

$(function() {
    $("#datepickerTo").datepicker({
        showButtonPanel: true,
        changeMonth: true,
        changeYear: true});
});

$(function() {
    $("button:first").button({
        icons: {
            primary: "ui-icon-search",
            secondary: "ui-icon-triangle-1-s"
        },
        text: true
    });
});

function slideDiv(){
    var display = $("#filter").css("display");
    if (display == 'block') {
        var icon = "ui-icon-triangle-1-e";
    } else {
        var icon = "ui-icon-triangle-1-s";    
    }
    $('#filter').slideToggle();
    
    $("button:first").button({
        icons: {
            primary: "ui-icon-search",
            secondary: icon
        },
        text: true
    });
}