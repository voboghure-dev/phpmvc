<?php
	/** @var app\core\View $this */
	/** @var app\models\ContactForm $model */

	use app\core\form\Form;

	$this->title = 'Contact';
?>
<h1>Contact</h1>

<?php $form = Form::begin( '', 'post' );?>
    <?php echo $form->field( $model, 'subject' );?>
    <?php echo $form->field( $model, 'email' );?>
    <?php echo $form->field( $model, 'body' );?>
    <button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end();?>