<?php if (isset($_exception)) { ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <?php
        $violations = $_exception->getViolations();

        foreach ($violations as $violation) {
            echo $violation->getMessage() . '<br>';
        }

        ?>
    </div>
<?php } ?>