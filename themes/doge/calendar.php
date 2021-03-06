<?php
/*
 * Template Name: Calendar
 */
get_header();

?>
<div id="calendar_page">
    <div class="row calendarnav">
        <div class="page-header clearfix">
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
    <div id="calendar_wrapper">    
        <div class="content" id="calendar">

        </div>
    </div>
</div>
<?php get_footer(); ?>