<?php get_header(); ?>

<main class="container mt-4">
    <div class="row">

        <div class="col-md">
            <div id="content" role="main">
                <?php get_template_part( 'loops/404' ); ?>
            </div><!-- /#content -->
        </div>

        <?php get_sidebar(); ?>

    </div><!-- /.row -->
</main><!-- /.container -->

<?php get_footer(); ?>
