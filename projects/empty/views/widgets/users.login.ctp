<form method="post" action="<?php echo $html->url('/login/');?>">
  <div id="loginheading">
    <h4>User Login</h4>
  </div>
  <div id="username">User Name:</div>
  <div id="input">
    <label>
      <input name="data[User][username]" type="text" class="input" id="textfield" />
    </label>
  </div>
  <div id="password">Password:</div>
  <div id="input02">
    <label>
      <input name="data[User][password]" type="password" class="input" id="textfield2" />
    </label>
  </div>
  <div id="loginbutton"><input type="submit" class="login" value="login" /></div>
  <div id="member">Not yet a Member? </div>
  <div id="register"><a href="<?php echo $html->url('/register/');?>" class="register">Register Now</a></div>
</form>
