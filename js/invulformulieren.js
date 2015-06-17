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
    console.log($( "#perceel" ).val());
    $.ajax({url: url , success: function(result){
        $("#vak").html(result);
    }});
}

function fillVakVerzaaid() {

    var url;
    url = "getVakVerzaaid.php?perceelID=" + $( "#perceel" ).val();
    console.log($( "#perceel" ).val());
    $.ajax({url: url , success: function(result){
        $("#vak").html(result);
    }});
}

function fillBoot() {

    var url;
    url = "getBoot.php?bedrijfID=" + $( "#bedrijf" ).val();
    console.log($( "#boot" ).val());
    $.ajax({url: url , success: function(result){
        $("#boot").html(result);
    }});
}