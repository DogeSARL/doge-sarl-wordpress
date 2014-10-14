<div class="row">
    <div class="page-header">
        <div class="pull-right">
            <div class="form-inline">
                <div class="btn-group">
                    <button class="btn btn-primary" data-calendar-nav="prev">&lt;&lt; Précédent</button>
                    <button class="btn" data-calendar-nav="today">Aujourd'hui</button>
                    <button class="btn btn-primary" data-calendar-nav="next">Suivant &gt;&gt;</button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-warning" data-calendar-view="year">Année</button>
                    <button class="btn btn-warning active" data-calendar-view="month">Mois</button>
                    <button class="btn btn-warning" data-calendar-view="week">Semaine</button>
                    <button class="btn btn-warning" data-calendar-view="day">Jour</button>
                </div>
            </div>
        </div>
        <h3></h3>
    </div>
</div>
<div class="content" id="calendar">

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
            language: 'fr-FR',
            onAfterViewLoad: function(view) {
                $('.page-header h3').text(this.getTitle());
                $('.btn-group button').removeClass('active');
                $('button[data-calendar-view="' + view + '"]').addClass('active');
            }
        });

    $('.btn-group button[data-calendar-nav]').each(function() {
        var $this = $(this);
        $this.click(function() {
            calendar.navigate($this.data('calendar-nav'));
        });
    });

    $('.btn-group button[data-calendar-view]').each(function() {
        var $this = $(this);
        $this.click(function() {
            calendar.view($this.data('calendar-view'));
        });
    });

</script>

<?php get_footer(); ?>