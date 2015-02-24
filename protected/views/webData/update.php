<?php
/* @var $this WebDataController */
/* @var $model WebData */

$this->breadcrumbs=array(
	'Web Datas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List WebData', 'url'=>array('index')),
	array('label'=>'Create WebData', 'url'=>array('create')),
	array('label'=>'View WebData', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage WebData', 'url'=>array('admin')),
);
?>

<h1>Update WebData <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>