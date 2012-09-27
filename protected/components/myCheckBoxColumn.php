<?php

class myCheckBoxColumn extends CCheckBoxColumn
{
	public $checked=false;

	protected function renderDataCellContent($row,$data)
	{
		if($this->value!==null)
			$value=$this->evaluateExpression($this->value,array('data'=>$data,'row'=>$row));
		else if($this->name!==null)
			$value=CHtml::value($data,$this->name);
		else
			$value=$this->grid->dataProvider->keys[$row];
		$options=$this->checkBoxHtmlOptions;
		$options['value']=$value;
		$options['id']=$this->id.'_'.$row;
		if(isset($this->checked) && $this->evaluateExpression($this->checked,array('data'=>$data,'row'=>$row)))
			echo CHtml::checkBox($this->id.'[]',true,$options);
		else
			echo CHtml::checkBox($this->id.'[]',false,$options);
	}
}
