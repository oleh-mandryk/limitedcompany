<div id="error"></div>
<div id="anchor_filter"></div>
<div class="filter_button">
    <button onclick="slideDiv();">Filtes</button>
    <a href="#anchor_chart">To graph</a>
</div>
<div id="filter" style="display: none;">
    <form action="/ajax" method="post">
        <fieldset>
            <legend title="Date">Date</legend>
                <label>Date from </label><input type="text" name="date_from" id="datepickerFrom" value="<?=$data['date_from']?>" />
                <label>Date to </label><input type="text" name="date_to" id="datepickerTo" value="<?=$data['date_to']?>" />
        </fieldset>
        <fieldset>
            <legend title="Department">Department</legend>
                <?$i=1; $class=null;?>
                <div class="clear_item">
                    <label class="all_record">
                        <input class='checkbox' type="checkbox" disabled="disabled" checked="checked" name="store_city_all" onclick="setAll(this, 1)" />
                        All
                    </label><br /> 
                    <label class="sum_record">
                        <input class='checkbox' type="checkbox" id="store_city_sum" checked="checked" name="store_city_sum" onclick="setSum(this, 1)" />
                        Sum
                    </label><br />   
                </div>
                <?foreach ($store_citys as $sc): ?>
                    <?if ($i===1) {$div='<div class="clear_item">';} else {$div=null;}?>
                    <?=$div?>
                    <label>
                        <input class="checkbox required" id="store_city_id" type="checkbox" disabled="disabled" checked="checked"  name="store_city[]" value="<?=$sc['id']?>" onclick="setChecked(this, 1)" />
                        <?=$sc['name']?>
                    </label><br />
                    <?$result=$i%3;?>
                    <?if ($result===0) {$div_end='</div>'; $i=0;} else {$div_end = null;}?>
                    <?=$div_end?>
                    <?$i++;?>
                <?endforeach?>
                <div class="clear"></div>
        </fieldset>
        <fieldset>
            <legend title="Entrepreneur">Entrepreneur</legend>
                <?$i=1; $class=null;?>
                <div class="clear_item">
                    <label class="all_record">
                        <input class='checkbox' type="checkbox" checked="checked" disabled="disabled" name="company_all" onclick="setAll(this, 2)" />
                        All
                    </label><br />
                    <label class="sum_record">
                        <input class='checkbox' type="checkbox" id="company_sum" checked="checked" name="company_sum" onclick="setSum(this, 2)" />
                        Sum
                    </label><br />   
                </div>
                <?foreach ($company_identifier as $ci): ?>
                    <?if ($i===1) {$div='<div class="clear_item">';} else {$div=null;}?>
                    <?=$div?>
                    <label>
                        <input class="checkbox required" id="company_id" type="checkbox" disabled="disabled" checked="checked" name="company[]" value="<?=$ci['id']?>" onclick="setChecked(this, 2)" />
                        <?=$ci['name']?>
                    </label><br />
                    <?$result=$i%2;?>
                    <?if ($result===0) {$div_end='</div>'; $i=0;} else {$div_end = null;}?>
                    <?=$div_end?>
                    <?$i++;?>
                <?endforeach?>
        </fieldset>
        <div class="clear"></div>
        <input type="hidden" id="controller" name="controller" value="<?=Request::initial()->controller()?>" />
        <input type="button" name="submit" id="ajax" class="submit" value="ОК" />
    </form>
</div>

<div id="description"></div>
<div id="wait"></div>
<div id="anchor_chart"></div>
<div class="filter_button"> <a href="#anchor_filter">To filter</a></div>
<div id="chart_div"></div>
<div id='table_div'></div>