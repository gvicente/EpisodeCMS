<h2>Choose project</h2>
<?php echo $form->create('Project', array('url'=>'/project')); ?>
<?php foreach($projects as $project_id=>$project): ?>
<div class="module">
    <h3>
        <input id="<?php echo $project_id ?>" value="<?php echo $project_id ?>" type="radio" name="data[Project][id]">
        <label for="<?php echo $project_id ?>"><?php echo $project['title'] ?></label>
    </h3>
    <div class="description">
        <?php echo $textile->process($project['description']); ?>
    </div>
</div>

<?php endforeach ?>
<?php echo $form->end('Next →'); ?>