jQuery(document).ready(function(){
    jQuery("#evenement_date_debut").datetimepicker({
        language: 'fr',
        pickTime: false,
        defaultDate: new Date()
    });
});

jQuery(document).ready(function(){
    jQuery("#evenement_date_fin").datetimepicker({
        language: 'fr',
        pickTime: false,
        defaultDate: new Date()
    });
});
