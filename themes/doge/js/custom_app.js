var calendar = $("#calendar").calendar(
    {
        tmpl_path: ajax_options.template_directory_uri + "/tmpls/",
        events_source: ajax_options.ajax_link + "?action=get_events",
        language: "fr-FR",
        onAfterViewLoad: function(view) {
        $(".page-header h3").text(this.getTitle());
        $(".btn-group button").removeClass("active");
        $("button[data-calendar-view=\'" + view + "\']").addClass("active");
    }
});

$(".btn-group button[data-calendar-nav]").each(function() {
    var $this = $(this);
    $this.click(function() {
    calendar.navigate($this.data("calendar-nav"));
    });
});

$(".btn-group button[data-calendar-view]").each(function() {
    var $this = $(this);
    $this.click(function() {
    calendar.view($this.data("calendar-view"));
    });
});