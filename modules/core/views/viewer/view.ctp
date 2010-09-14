<h2><?php echo $data['entry'][$data['model']]['title'] ?></h2>
<?php $value = $data['model'].$data['entry'][$data['model']]['id'].'before'; echo @$$value; ?>
<div class="post">
	<?php $value = $data['model'].$data['entry'][$data['model']]['id'].'before_content'; echo @$$value; ?>
	<div class="content"><?php echo $data['entry'][$data['model']]['content'] ?></div>
	<?php $value = $data['model'].$data['entry'][$data['model']]['id'].'after_content'; echo @$$value; ?>
	<div class="bottom">
	<?php $value = $data['model'].$data['entry'][$data['model']]['id'].'bottom'; echo @$$value; ?>
	</div>
</div>
<?php $value = $data['model'].$data['entry'][$data['model']]['id'].'after'; echo @$$value; ?>

<?php if($data['entry'][$data['model']]['slug'] == 'resume'): ?>
<!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="http://vkontakte.ru/js/api/openapi.js?9" charset="windows-1251"></script>

<script type="text/javascript">
  VK.init({apiId: 1945878, onlyWidgets: true});
</script>

<!-- Put this div tag to the place, where the Comments block will be -->
<div id="vk_comments"></div>
<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 20, width: "496"});
</script>
<?php endif; ?>
