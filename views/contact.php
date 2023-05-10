<?php
	/** @var voboghure\phpmvc\View $this */
	/** @var app\models\ContactForm $model */

	use voboghure\phpmvc\form\Form;
	use voboghure\phpmvc\form\InputField;
	use voboghure\phpmvc\form\TextareaField;

	$this->title = 'Contact';
?>
<h1>Contact</h1>

<?php $form = Form::begin( '', 'post' );?>
<?php echo new InputField( $model, 'subject' ); ?>
<?php echo new InputField( $model, 'email' ); ?>
<?php echo new TextareaField( $model, 'body' ); ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end();?>