<?php
/* @var $this WebDataController */
/* @var $model WebData */

$this->breadcrumbs=array(
	'Web Datas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List WebData', 'url'=>array('index')),
	array('label'=>'Manage WebData', 'url'=>array('admin')),
);
?>

<h1>Create WebData</h1>

<?php $this->renderPartial('/webData/_form', array('model'=>$model)); ?>