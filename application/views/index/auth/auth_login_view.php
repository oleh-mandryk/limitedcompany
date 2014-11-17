<?if($errors):?>
<?foreach ($errors as $error):?>
<div class="error"><?=$error?></div>
<?endforeach?>
<?endif?>
<p>Enter your username and password to access the site.</p>
<form action="/login" method="post">
<div>
<label>Login</label>
</div>
<div>
<input class="login" type="text" name="username" value=""/>
</div>
<div>
<label>Password</label>
</div>
<div>
<input class="login" type="password" name="password" value=""/>
</div>
<div>
<input class="checkbox" type="checkbox" name="remember" value="checkbox1" /><label>Remember me</label>
</div>
<div class="clear"> </div>
<input type="submit" name="submit" class="submit" value="Go" />
<div class="clear"> </div>
</form>