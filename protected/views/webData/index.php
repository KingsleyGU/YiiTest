<?php
/* @var $this WebDataController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Web Datas',
);

$this->menu=array(
	array('label'=>'Create WebData', 'url'=>array('create')),
	array('label'=>'Manage WebData', 'url'=>array('admin')),
);
?>

<h1>Web Datas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
