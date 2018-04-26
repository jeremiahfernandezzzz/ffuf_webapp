<!-- app/view/update.php -->
<div class="row">
    <div class="col-sm-5">
        <?= $this->insert('ui/error-block'); ?>
        <h3>Update Task</h3>
        <form action="task/<?= $task->getId() ?>/update" method="GET">
            <input type="hidden" name="csrf-token" value="<?= $_csrfToken ?>"/>
            <input type="hidden" name="id" value="<?= $task->getId() ?>">
            <input type="text" name="newtask" id="task" value="<?= $task->getTask() ?>" class="form-control"><br>
            <div class="btn-group pull-right">
                <a href="/ffuf_webapp" type="button" class="btn btn-default btn-warning"><i class="fa fa-hand-o-left"> Go Back</i></a>
                <button type="submit" class="btn btn-success"><i class="fa fa-refresh"> Update</i></button>
            </div>
        </form>
    </div>
</div>