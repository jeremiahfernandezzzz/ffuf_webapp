<!-- app/view/pages/index.php -->

<!-- app/view/layout/main.php -->
<?= $this->insert('ui/error-block'); ?>
<!DOCTYPE html>
<html>
<head>

    <!-- ... -->

    <link rel="stylesheet" href="assets/components/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/components/fontawesome/css/font-awesome.min.css">
    <head>
<body>

<div class="container" style="padding-top: 70px;">
    <div style="border:solid 1px gray; border-radius: 10px ">
        <div class="text-center"  style="padding: 30px 30px 10px 30px">
            <table class="table">
            <?php foreach ($tasks as $task) : ?>
                <div class="row task-row">
                    <!-- controls buttons will be placed here -->
                    <tr>
                        <td class="col">
                            <div>
                                <?= $task->getTask() ?>
                            </div>
                        </td>
                        <td class="col">
                            <div class="btn-group">

                                <form action="task/<?= $task->getId(); ?>/" method="GET">
                                    <input type="hidden" name="csrf-token" value="<?= $_csrfToken ?>"/>
                                    <input type="hidden" name="id" value="<?= $task->getId(); ?>">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-pencil" style="color:black">edit</i>
                                    </button>
                                </form>
                                <!--<i class="fa fa-pencil" style="color:black">edit</i>-->

                            </div>
                        </td>

                        <td class="col">
                            <div class="btn-group">
                                <form action="task/<?= $task->getId(); ?>/" method="POST">
                                    <input type="hidden" name="csrf-token" value="<?= $_csrfToken ?>"/>
                                    <!--<input type="hidden" name="http-method” value="DELETE">-->
                                    <input type="hidden" name="id" value="<?= $task->getId(); ?>">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash">delete</i>
                                    </button>
                                </form>
                            </div>
                        </td>

                        <td class="col">
                            <form action="task/<?= $task->getId(); ?>/update/time/" method="POST" >
                                <input type="hidden" name="csrf-token" value="<?= $_csrfToken ?>"/>
                                <input type="hidden" name="id" value="<?= $task->getId() ?>">
                                <input type="checkbox" name="iCheck" onChange="this.form.submit()"
                                    <?= ($task->getFinishedAt() === null) ? '' : 'checked' ?> >
                            </form>
                        </td>
                    </tr>
                </div>
            <?php endforeach; ?>

            </table>
        </div>
    </div>

    <br/>
    <div class="text-center" style="border:solid 1px gray; border-radius: 10px ">
        <div>
            <div style="padding: 50px">
                <h3 class="text-center">Add New Task</h3>
                <form action="task/create/" method="post">
                    <input type="hidden" name="csrf-token" value="<?= $_csrfToken ?>">
                    <input type="text" class="form-control" id="task" name="task"><br>
                    <button type="submit" class="btn btn-success btn-block">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ... -->

<script src="assets/components/jquery/jquery.js"></script>
</body>
</html>



