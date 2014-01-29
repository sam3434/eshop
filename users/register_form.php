<form action="register.php" method="post" class="_form">
	<label for="">Логин<span class="error_message">*</span> </label> <br>
	<input type="text" name="" id="login" 
		title = <?php echo "'$tool_login'"; ?>   		 >
		<span class="error_form"></span>
		<br>

	<label for="">Пароль<span class="error_message">*</span></label> <br>
	<input type="password" name="" id="pass"  
		title = <?php echo "'$tool_pass'"; ?>    		>
		<span class="error_form"></span>
	<br>

	<label for="">Повтор пароля<span class="error_message">*</span></label> <br>
	<input type="password" name="" id="pass_rpt"  
		title = <?php echo "'$tool_pass_rpt'";  		 ?> >
		<span class="error_form"></span>
	<br>

	<label for="">Фамилия<span class="error_message">*</span></label> <br>
	<input type="text" name="" id="fam"  
		title = <?php echo "'$tool_fam'"; ?>  >
		<span class="error_form"></span>
	<br>

	<label for="">Имя</label> <br>
	<input type="text" name="" id="im"  
		title = <?php echo "'$tool_im'"; ?>  >
		<span class="error_form"></span>
	<br>

	<label for="">Отчество</label> <br>
	<input type="text" name="" id="ot"  
		title = <?php echo "'$tool_ot'"; ?>  >
		<span class="error_form"></span>
	<br>

	<label for="">Email</label> <br>
	<input type="text" name="" id="email"  
		title = <?php echo "'$tool_email'"; ?>   		 >
		<span class="error_form"></span>
	<br>

	<label for="">Моб. телефон<span class="error_message">*</span></label> <br>
	<input type="text" name="" id="tel"  
		title = <?php echo "'$tool_tel'"; ?>  >
		<span class="error_form"></span>
	<br>

	<label for="">Адрес доставки<span class="error_message">*</span></label> <br>
	<textarea name="" id="addr" cols="30" rows="10" class="round5" maxlength="200" title = <?php echo "'$tool_addr'"; ?> > <br>
		
	</textarea>
		<span class="error_form"></span>
	<br>
	<input class="btn" type="submit" value="Регистрация" onsubmit="ajax_reg();return false;">				
</form>