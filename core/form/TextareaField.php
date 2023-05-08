<?php
namespace app\core\form;

class TextareaField extends BaseField {

	public function renderInput(): string {
		return sprintf( '<textarea name="%s" id="%s" class="form-control%s">%s</textarea>',
			$this->attribute,
			$this->attribute,
			$this->model->hasError( $this->attribute ) ? ' is-invalid' : '',
			$this->model->{$this->attribute},
		);
	}
}