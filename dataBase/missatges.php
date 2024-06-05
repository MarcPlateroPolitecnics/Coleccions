<?php if (isset($_SESSION['missatges'])) { ?>
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <?php
            echo $_SESSION['missatges'];
            unset($_SESSION['missatges']);
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

<?php if (isset($_SESSION['error'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>