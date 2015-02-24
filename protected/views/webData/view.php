<?php
/* @var $this WebDataController */
/* @var $model WebData */

$this->breadcrumbs=array(
	'Web Datas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List WebData', 'url'=>array('index')),
	array('label'=>'Create WebData', 'url'=>array('create')),
	array('label'=>'Update WebData', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete WebData', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage WebData', 'url'=>array('admin')),
);
?>

<h1>View WebData #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'postTime',
		'content',
		'id',
		'image',
		'imageName',
	),
)); ?>
