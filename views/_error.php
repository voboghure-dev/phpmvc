<?php
	/** @var Exception $exception */

    $this->title = $exception->getCode();
?>
<h3><?php echo $exception->getCode(); ?> - <?php echo $exception->getMessage(); ?></h3>