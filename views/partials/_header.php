<header>
    <?php
        if ( isset( $_SESSION['user'] ) && $_SESSION['user']->is_admin ) {
            require '_navAdmin.php';
        } elseif ( isset( $_SESSION['user'] ) ) {
            require '_navUser.php';
        } else {
            require '_navBase.php';
        }

    require '_search.php'; ?>
</header>