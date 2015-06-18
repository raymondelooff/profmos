$( document ).ready(function(){
    toggleVerzaaien();
    toggleMonster();
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
    url = "getVakVerzaaien.php?perceelID=" + $( "#VerzaaienPerceel" ).val();
    $.ajax({url: url , success: function(result){
        $("#VerzaaienVak").html(result);
    }});
}

function fillBoot() {

    var url;
    url = "getBoot.php?bedrijfID=" + $( "#bedrijf" ).val();
    $.ajax({url: url , success: function(result){
        $("#boot").html(result);
    }});
}

function toggleMonster() {
    if( $( "#monster" ).val() === "Ja" ) {
        $( "#labelDiv" ).show();
    }
    else {
        $( "#labelDiv" ).hide();
    }
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
