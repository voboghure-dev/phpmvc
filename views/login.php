<?php
	/** @var \app\models\User $model */

	$this->title = 'Login';
?>
<h1>Login</h1>

<?php $form = \voboghure\phpmvc\form\Form::begin( '', 'post' );?>
<?php
	echo $form->field( $model, 'email' );
	echo $form->field( $model, 'password' )->passwordField();
?>
    <button type="submit" class="btn btn-primary">Submit</button>
<?php \voboghure\phpmvc\form\Form::end();?>