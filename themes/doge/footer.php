<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
        <footer>
            bloc footer
        </footer>
    </div>

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/underscore-min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/calendar.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/language/fr-FR.js"></script>
<script type="text/javascript">
    var calendar = $("#calendar").calendar(
        {
            tmpl_path: "<?php echo get_template_directory_uri(); ?>/tmpls/",
            events_source: function () { return []; },
            language: 'fr-FR'
        });

    $('button[data-calendar-nav]').each(function() {
        var $this = $(this);
        $this.click(function() {
            calendar.navigate($this.data('calendar-nav'));
        });
    });

</script>

</body>
</html>