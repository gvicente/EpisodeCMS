<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><?php echo $headers ?></head>
<body>
<div id="headerbg">
  <div id="headerblank">
    <div id="header">
      <div id="menu">
        <ul>
          <?php echo $this->Theme->menu('main', array('class'=>'menu')) ?>
        </ul>
      </div>
      <div id="login">
        <div id="logintxtblank">
      <?php if(!$user): ?>
        <?php echo $this->Theme->widget('users/login'); ?>
      <?php else: ?>
        <p>Logined as <?php echo $user['User']['username'] ?>.</p>
        <p><a href="<?php echo $html->url('/logout/');?>" class="register">Log Out</a>.</p>
      <?php endif ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="contentbg">
  <div id="contentblank">
    <div id="content">
      <div id="contentleft">
        <?php echo $this->Theme->widget('blog/brief') ?>
        <?php echo $this->Theme->widget('resources/list') ?>
        <?php echo $this->Theme->widget('newsletter/subscribe') ?>
      </div>
      <div id="contentmid">
        <?php echo $content_for_layout ?>
      </div>
      <div id="contentright">
        <?php echo $this->Theme->widget('gallery/latest') ?>
      </div>
    </div>
  </div>
</div>
<div id="footerbg">
  <div id="footerblank">
    <div id="footer">
      <div id="footerbox">
        <div class="footerheading"><h4>Tempus</h4></div>
        <div class="footertxt">Donec posuere bibendum erat.  commodo consectetuer tellus. Ut ut tellus eget</div>
        <div class="footerbutton"><a href="#" class="button">read more</a></div>
      </div>
      <div id="footermid"><div class="footerheading"><h4>Neque</h4></div>
      <div class="footertxt">Neque nisl porttitor dolor, ut posuere nibh lectus vel pede. Nam non elit.</div>
      <div class="footerbutton"><a href="#" class="button">read more</a></div>
      </div>
      <div id="footerlast">
        <div class="footerheading">
          <h4>Curabitur</h4>
        </div>
        <div class="footertxt">Eque nisl porttitor dolor, ut posuere nibh lectus vel pede. Nam non elit. </div>
        <div class="footerbutton"><a href="#" class="button">read more</a></div>
      </div>
      <div id="footerlinks"><a href="#" class="footerlinks">Home</a> | <a href="#" class="footerlinks">About Us</a> | <a href="#" class="footerlinks">Support</a> | <a href="#" class="footerlinks">Forum</a> | <a href="#" class="footerlinks">Development</a> | <a href="#" class="footerlinks">Conact Us</a></div>
      <div id="copyrights"><?php echo $this->Theme->block('copyright'); ?></div>
      <div id="designedby">Designed by <a href="http://www.templateworld.com" target="_blank" class="designedby">TemplateWorld</a> and brought to you by <a href="http://www.smashingmagazine.com" target="_blank" class="designedby">SmashingMagazine</a></div>
      <div id="validation"><a href="http://validator.w3.org/check?uri=referer" class="xhtml">xhtml</a><a href="http://jigsaw.w3.org/css-validator/check/referer" class="css">css</a></div>
    </div>
  </div>
</div>
</body>
</html>
