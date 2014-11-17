<?if($errors):?>
<?foreach ($errors as $error):?>
<div class="error"><?=$error?></div>
<?endforeach?>
<?endif?>
<form action="/menu/edit/<?=$id?>" method="post">
<div>
    <label>Url</label>
</div>
<div>
    <?=Form::input('url', $data['url'])?>
</div>
<div>
    <label>Назва</label>
</div>
<div>
    <?=Form::input('name', $data['name'])?>
</div>

<div>
    <label>Сортування</label>
</div>
<div>
    <?=Form::input('sort', $data['sort'])?>
</div>

<div>
    <?=Form::label('status', 'Публікація')?>
</div>
<div>
    <?=Form::checkbox('status', 1, (bool) $data['status'], array('class' => 'checkbox'))?>
</div>

<div class="clear"> </div>
    <input type="submit" name="submit" class="submit" value="Додати" />
<div class="clear"> </div>
</form>