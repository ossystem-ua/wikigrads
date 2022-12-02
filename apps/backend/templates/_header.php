<header>
    <div class="header-container">
        <?php if ($sf_user->isAuthenticated()) : ?>
            <?php include_component('main', 'menu'); ?>
        <?php endif; ?>
    </div>
</header>