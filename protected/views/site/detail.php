<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - detail';
$this->breadcrumbs=array(
	'detail',
);
?>
<style type="text/css">
.general_detail{
	padding-top: 20px;
	padding-left: 15%;
	padding-right: 15%;
	padding-bottom: 20px;
}
.detail_img{

	width: 100%;
}
.detail_content{
	margin: 15px;
	font-size: 20px;
}
.comments_title{
	color: red;
}
.comments_list{
    color: #888;
    font-size: 14px;
}
.comment_div{
	padding:15px;
	background-color: #eee;
}
textarea{
	width: 80%;
	height:100px;
	border: none;
	background-color:rgb(165, 163, 229);
	padding: 10px;
	font-size: 15px;
}
.smb_btn{
	margin-top:10px;
	border: none;
	background-color:#D96831;
	padding:10px 15px;
	border-radius: 5px;
	color: #fff;
	font-size: 15px;
}
</style>
<div class="general_detail">
	<img class="detail_img" src="<?php echo Yii::app()->request->baseUrl;?>/images/upload/<?php echo $imageName; ?>" >
	<p class="detail_content"><?php echo $content;?></p>
	<div class="comment_div">
		<h2 class="comments_title">comments:</h2><hr/>
		<?php 
			    $ComJson = json_decode($commentJson);
			    $JsonLen = count($ComJson);
			    if($JsonLen == 0){
		?>
				<p class="comments_list">No comments right now.</p>
		<?php 	}
		     	else{
                     for($m=0;$m<$JsonLen;$m++){
     	?>
     	        <p class="comments_list"><span style="color:blue;padding-left:10px;font-weight:bold; display:inline-block;padding-right:10px;"><?php echo json_decode($ComJson[$m])->author; ?></span><?php echo json_decode($ComJson[$m])->content; ?></p><hr/>
		<?php }
		}	     		
		?>
		<form action="<?php echo Yii::app()->request->baseUrl;?>/site/comment" method="POST">
			<input type="hidden" name="id" value="<?php echo $_GET['_id']; ?>">
			<textarea name="content" ></textarea><br>
			<input type="submit" value="submit" class="smb_btn">
		</form>	
	</div>
</div>
<script type="text/javascript">
$(function(){
	$( "ul#yw0 li:first-child").addClass('active');

})
</script>
