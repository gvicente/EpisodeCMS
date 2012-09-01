<div id="leftnavheading">
  <h4>Resources</h4>
</div>
<div id="leftnav">
  <ul>
  <?php foreach ($data as $item): ?>
    <li><a target="_blank" href="<?php echo $item['Resource']['link'] ?>" class="leftnav"><?php echo $item['Resource']['title'] ?></a></li>
  <?php endforeach ?>
  </ul>
</div>