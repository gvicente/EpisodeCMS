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
        <div id="leftheading">
          <h4>News &amp; Updates</h4>
        </div>
        <div class="lefttxtblank">
          <div class="lefticon">16</div>
          <div class="leftboldtxtblank">
            <div class="leftboldtxt">Pulvinar interdum ...</div>
            <div class="lefttxt">By Jack Son  | 11:55 AM</div>
          </div>
          <div class="leftnormaltxt">Etiam auctor nisl adipiscing sem.  erat urna fringilla sit ametvestibulum.</div>
          <div class="morebutton"><a href="#" class="more">read more... </a></div>
        </div>
        <div class="lefttxtblank02">
          <div class="lefticon">16</div>
          <div class="leftboldtxtblank">
            <div class="leftboldtxt">Aulvinar gnterdum ...</div>
            <div class="lefttxt">By Jack Son  | 11:55 AM</div>
          </div>
          <div class="leftnormaltxt">Stiam auctor nisl adipiscing sem.  erat urna fringilla sit ametvestibulum.</div>
          <div class="morebutton"><a href="#" class="more">read more... </a></div>
        </div>
        <div class="lefttxtblank02">
          <div class="lefticon">16</div>
          <div class="leftboldtxtblank">
            <div class="leftboldtxt">Qulvinar snterdum ...</div>
            <div class="lefttxt">By Jack Son  | 11:55 AM</div>
          </div>
          <div class="leftnormaltxt">Etiam auctor nisl adipiscing sem.  erat urna fringilla sit ametvestibulum.</div>
          <div class="morebutton"><a href="#" class="more">read more... </a></div>
        </div>
        <div id="leftnavheading">
          <h4>Resources</h4>
        </div>
        <div id="leftnav">
          <ul>
            <li><a href="#" class="leftnav">Mauris neque egestas justo </a></li>
            <li><a href="#" class="leftnav">Neque eros a nequestibulum </a></li>
            <li><a href="#" class="leftnav">Primis in faucibus orci luctus </a></li>
            <li><a href="#" class="leftnav">Posuere cubilia Curae </a></li>
            <li><a href="#" class="leftnav">Ulla risus risus sagittis in </a></li>
            <li><a href="#" class="leftnav">Lobortis sed tincidunt at est.</a></li>
            <li><a href="#" class="leftnav">Donec posuere egestas ipsum</a></li>
            <li><a href="#" class="leftnav">Cras ac magna vel justo </a></li>
            <li><a href="#" class="leftnav">Sollicitudin viverra. </a></li>
            <li><a href="#" class="leftnav">Nullam elementum nibh ut </a></li>
          </ul>
        </div>
      </div>
      <div id="contentmid">
        <?php echo $content_for_layout ?>
        <div class="midheading">
          <h2>Latest Projects<span class="projectheading">Wednesday, May 07, 2008</span></h2>
        </div>
        <div id="projectbg">
          <div id="projectthumnail"></div>
          <div id="projecttxtblank">
            <div id="projecttxt"><span class="projectboldtxt">Nulla venenati sed varius an teproin</span> libero aecenas dapibus am gravida ante quis arcu liquam eleifend. Donec at elit. Integer lectus dolor utrum a volutpat .<br />
            </div>
            <div id="moreproject"><a href="#" class="moreproject">read more</a></div>
          </div>
        </div>

        <div class="midheading">
          <h2>Our main purpose</h2>
        </div>
        <div id="purposetxt">Donec posuere bibendum erat. Etiam commodo consectetuer tellus. Ut ut tellus eget nisl fermentum egestas. Ut consequat, </div>
        <div id="purposenav">
          <ul>
            <li><a href="#" class="purposenav">Conubia nostra per inceptos</a></li>
            <li><a href="#" class="purposenav">Etiam porta ullam sodales libe</a></li>
          </ul>
          <ul>
            <li><a href="#" class="purposenav">Lobortis ac mauris mauris</a></li>
            <li><a href="#" class="purposenav">Sed varius ante roin sed ped</a></li>
          </ul>
        </div>
        <div class="midtxt"><span class="midboldtxt">Morbi porta odio id erat. Curabitur ut massa uspendisse ipsum. In vitae dolor eget lorem</span> Suspendisse massa lacus, ullamcorper ac, pulvinar ut, aliquet et, elit. </div>
      </div>
      <div id="contentright">
        <div class="rightheading">
          <h4>Photo Gallery</h4>
        </div>
        <div id="galleryblank">
          <div id="rightpic"><a href="#" class="rightpic"></a></div>
          <div id="rightpic02"><a href="#" class="rightpic02"></a></div>
          <div id="rightpic03"><a href="#" class="rightpic03"></a></div>
          <div class="viewbutton"><a href="#" class="view"> view more</a></div>
          <div class="rightheading">
            <h4>Creative story</h4>
          </div>
          <div class="righttxt"><span class="rightboldtxt">01. aliquet tempor nisi tellus </span>bibendum nunc. Sed venenatis scelerisque ipsum.</div>
          <div class="righttxt"><span class="rightboldtxt">02.  Tempor nisi tellus </span><br />
            Ndum nunc. Sed venenatis scelerisque ipsum.</div>
          <div class="righttxt"><span class="rightboldtxt">03.  Kempor sisi vellus </span><br />
            Qchdum nunc. Sed venenatis scelerisque ipsum.</div>
          <div class="righttxt"><span class="rightboldtxt">04. Aliquet tempor nisi tellus </span>bibendum nunc. Sed venenatis</div>
          <div class="viewbuttonbot"><a href="#" class="view"> read more</a></div>
        </div>
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
      <div id="copyrights">© Copyright Information Goes Here. All Rights Reserved.</div>
      <div id="designedby">Designed by <a href="http://www.templateworld.com" target="_blank" class="designedby">TemplateWorld</a> and brought to you by <a href="http://www.smashingmagazine.com" target="_blank" class="designedby">SmashingMagazine</a></div>
      <div id="validation"><a href="http://validator.w3.org/check?uri=referer" class="xhtml">xhtml</a><a href="http://jigsaw.w3.org/css-validator/check/referer" class="css">css</a></div>
    </div>
  </div>
</div>
</body>
</html>
