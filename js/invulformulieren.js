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

//functie opdat vak gekozen kan worden
function fillVak() {

    var url;
    url = "/ajax/getVak.php?perceelID=" + $( "#perceel" ).val();
    $.ajax({url: url , success: function(result){
        $("#vak").html(result);
    }});
}

//functie opdat vak gekozen kan worden
function fillVakVerzaaien() {

    var url;
    url = "/ajax/getVakVerzaaien.php?perceelID=" + $( "#verzaaienPerceelSelect" ).val();
    $.ajax({url: url , success: function(result){
        $("#verzaaienVak").html(result);
    }});
}

//functie opdat boot gekozen kan worden
function fillBoot() {

    var url;
    url = "/ajax/getBoot.php?bedrijfID=" + $( "#bedrijf" ).val();
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
