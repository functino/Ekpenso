<div style="text-align:center;margin-top:10px; font-family: Trebuchet MS, sans-serif; ">
<div style="font-size:24px;font-weight:bold; color:#264b76; letter-spacing:0px;">
<?php __('User.register_heading');?>
</div>
<div style="font-size:13px;color:#53709D; font-weight:bold;">
<?php __('Users.register_subheading');?>
</div> 
</div>
<form action="<?php echo $html->url('/openid/register');?>" method="POST" style="width:400px; margin:0 auto; ">
<table>
	<tr>
		<td>
			<?php echo $form->label('User.username', __('User.username', true));?>
		</td>
		<td>
			<?php echo $form->text('User.username');?>
		</td>
		<td id="UserUsernameTd">
			<?php echo $form->error('User.username');?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo $form->label('User.email', __('User.email', true));?>
		</td>
		<td>
			<?php echo $form->text('User.email');?>
		</td>
		<td id="UserEmailTd">
			<?php echo $form->error('User.email');?>
		</td>
	</tr>
</table>

<?php echo $form->checkbox('User.agb');?>
<?php echo $form->label('User.agb', __('User.accept_agb', true));?>
<?php echo $form->error('User.agb', __('error.User.accept_agb', true));?>

<?php echo $button->submit(__('User.submit.register', true), 'icons/f/user_add.png');?>
</form>

<script type="text/javascript">



$('#UserEmailTd').append('<span id="UserEmailCheck"></span>');
$('#UserEmail').blur(checkEmail);
$('#UserEmail').keyup(checkEmail);
var checkEmailTimeout = undefined;

function checkEmail(){
 	if(checkEmailTimeout != undefined) {
		clearTimeout(checkEmailTimeout);
	} 	
	checkEmailTimeout = setTimeout(function() {
		checkEmailTimeout = undefined;
	 	var name = $('#UserEmail').val();
	 	if(name.length> 4)
	 	{
			$.get('<?php echo $html->url('/users/checkEmail/');?>' + name, function(text){
				$('#UserEmailCheck').html(text);
			});
		}
	}, 1000);
}

$('#UserUsernameTd').append('<span id="UserUsernameCheck"></span>');
$('#UserUsername').blur(checkUsername);
$('#UserUsername').keyup(checkUsername);
var checkUsernameTimeout = undefined;
function checkUsername(){
 	var name = $('#UserUsername').val();
 	
	if(checkUsernameTimeout != undefined) {
		clearTimeout(checkUsernameTimeout);
	} 	
	checkUsernameTimeout = setTimeout(function() {
		checkUsernameTimeout = undefined;
		if(name.length >= 3)
	 	{
			$.get('<?php echo $html->url('/users/checkUsername/');?>' + name, function(text){
				$('#UserUsernameCheck').html(text);
			});
		}
		else
		{
			$('#UserUsernameCheck').html('<span style="color:red;"><?php __('error.User.username.length');?></span>');	
		}
	}, 500);
 }
</script>