function fillVak() {

    var url;
    url = "getVak.php?perceelID=" + $( "#perceel" ).val();
    console.log($( "#perceel" ).val());
    $.ajax({url: url , success: function(result){
        $("#vak").html(result);
    }});
}

$('.date').datepicker({
});