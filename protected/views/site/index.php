<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?php
	 for($i=0;$i<count($model);$i++)
	 {  $tmp = json_decode($model[$i]); ?>
	    <div class="outer_div">
	    	<div class="desc_div" style="display:none;">
	    		<p><?php echo $tmp->content; ?></p>
	    	</div>
			<a class="image_link" href="<?php echo Yii::app()->request->baseUrl;?>/site/detail?_id=<?php echo $tmp->id;?>"><img src="<?php echo Yii::app()->request->baseUrl;?>/images/upload/<?php 
			echo $tmp->imageName; ?>" class="image_show"></a>
		</div>

<?php } ?>
			
<script>
$('.image_show').load(function(){
    var width = $('.outer_div').width();
    $('.desc_div').width(width);
    $(this).width(width);
    $(this).height(width);
});
$('.outer_div').mouseenter(function()
{
   $(this).find('.desc_div').css('display','block');
})
$('.outer_div').mouseleave(function()
{
    $(this).find('.desc_div').css('display','none');
})
</script>

