<div style="text-align:center;margin-top:10px; font-family: Trebuchet MS, sans-serif; ">
<div style="font-size:24px;font-weight:bold; color:#264b76; letter-spacing:0px;">
<?php echo $html->image('openid-logo-small.png', array('title'=>'Login via OpenId'));?>
</div>
</div>
<form action="<?php echo $html->url('/openid/login');?>" method="POST" style="width:400px; margin:0 auto; ">
<?php echo $form->text('OpenidUrl.openid', array('style'=>"background: #FFFFFF url('/img/openid-login-bg.gif') no-repeat scroll 0pt 50%; padding-left: 18px;"));?>
<?php echo $button->submit(__('Openid.login', true), 'icons/f/user_add.png');?>
</form>


<?php if(isset($message)) echo $message;?>

