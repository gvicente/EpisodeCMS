<div class="rightheading">
    <h4>Photo Gallery</h4>
</div>
<div id="galleryblank">
    <?php foreach ($data as $item): ?>
    <div><a href="<?php echo $this->Html->url($item['Gallery']['photo']) ?>">
        <?php echo $this->Html->image($this->Html->url($item['Gallery']['photo']), array('width'=>200)) ?>
    </a></div><br>
    <?php endforeach ?>
    <div class="viewbutton"><a href="#" class="view"> view more</a></div>

    <div class="rightheading">
        <h4>Creative story</h4>
    </div>
    <div class="righttxt"><span class="rightboldtxt">01. aliquet tempor nisi tellus </span>bibendum nunc. Sed venenatis
        scelerisque ipsum.
    </div>
    <div class="righttxt"><span class="rightboldtxt">02.  Tempor nisi tellus </span><br/>
        Ndum nunc. Sed venenatis scelerisque ipsum.
    </div>
    <div class="righttxt"><span class="rightboldtxt">03.  Kempor sisi vellus </span><br/>
        Qchdum nunc. Sed venenatis scelerisque ipsum.
    </div>
    <div class="righttxt"><span class="rightboldtxt">04. Aliquet tempor nisi tellus </span>bibendum nunc. Sed venenatis
    </div>
    <div class="viewbuttonbot"><a href="#" class="view"> read more</a></div>
</div>