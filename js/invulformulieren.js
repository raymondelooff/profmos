$( document ).ready(function(){
    toggleVerzaaien();
});

$('.date').datepicker({
    format: "dd-mm-yyyy",
    todayBtn: "linked",
    language: "nl",
    calendarWeeks: true,
    todayHighlight: true
});

function fillVak() {

    var url;
    url = "getVak.php?perceelID=" + $( "#perceel" ).val();
    $.ajax({url: url , success: function(result){
        $("#vak").html(result);
    }});
}

function fillVakVerzaaien() {

    var url;
    url = "getVakVerzaaien.php?perceelID=" + $( "#perceel_verzaaien" ).val();
    $.ajax({url: url , success: function(result){
        $("#vak_verzaaien").html(result);
    }});
}

function fillBoot() {

    var url;
    url = "getBoot.php?bedrijfID=" + $( "#bedrijf" ).val();
    $.ajax({url: url , success: function(result){
        $("#boot").html(result);
    }});
}

function toggleVerzaaien() {
    if( $( "#verzaaien" ).val() === "Ja" ) {
        $( "#verzaaienBedrijf" ).show();
        $( "#verzaaienPerceel" ).show();
        $( "#verzaaienVak" ).show();
        $( "#verzaaienOppervlakte" ).show();
    }
    else if ($( "#verzaaien" ).val() === "Nee" ) {
        $( "#verzaaienBedrijf" ).hide();
        $( "#verzaaienPerceel" ).hide();
        $( "#verzaaienVak" ).hide();
        $( "#verzaaienOppervlakte" ).hide();
    }
}
