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

<?=Form::open('register')?>
<div>
    <label>Тип реєстрації</label>
</div>
<div>
    <input class="checkbox" type="radio" name="type_register" value="1" <?if ($type_register == '1') {echo 'checked="checked"';}?> />
    <label>Користувач</label>
    <input class="checkbox" type="radio" name="type_register" value="2" <?if ($type_register == '2') {echo 'checked="checked"';}?> />
    <label>Адміністратор</label>
</div>
<div>
    <?=Form::label('username', 'Логін')?>
</div>
<div>
    <?=Form::input('username', $data['username'])?>
</div>
<div>
<?=Form::label('email', 'E-mail')?>
</div>
<div>
<?=Form::input('email', $data['email'])?>
</div>
<div>
<?=Form::label('password', 'Пароль')?>
</div>
<div>
<?=Form::password('password', $data['password'])?>
</div>
<div>        
<?=Form::label('password_confirm', 'Підтвердження паролю')?>
</div>
<div>
<?=Form::password('password_confirm', $data['password_confirm'])?>
</div>
<div class="clear"></div>
<div> 
<?=Form::submit('submit', 'Зареєструватись', array('class' => 'submit'))?>
</div>
<?=Form::close()?>