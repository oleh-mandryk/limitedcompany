<?if($errors):?>
<?foreach ($errors as $error):?>
<? if (is_array($error)){ ?>
<?foreach ($error as $item):?>
<div class="error"><?=$item?></div>
<?endforeach?>
<?} else {?>
<div class="error"><?=$error?></div>
<?}?>
<?endforeach?>
<?endif?>
<div class="clear"></div>
<div class="add">
<?=HTML::image('media/img/add.png')?>
<?=HTML::anchor('register', 'Додати')?>
</div>
<div class="clear"></div>
<script type='text/javascript'>
    
    //Таблиця
    google.load('visualization', '1', {packages:['table']});
    google.setOnLoadCallback(drawTable);
    var options = {
            allowHtml: true,
            showRowNumber: true
        }
    
    function drawTable() {
        var data = new google.visualization.DataTable(<?=$json_table?>);
        var table = new google.visualization.Table(document.getElementById('table_div'));
        var formatter = new google.visualization.NumberFormat(
            {decimalSymbol: '.'});
        table.draw(data, options);
    }
   </script>
<div id='table_div'></div>