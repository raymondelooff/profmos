function fillVak(){var e;e="getVak.php?perceelID="+$("#perceel").val(),console.log($("#perceel").val()),$.ajax({url:e,success:function(e){$("#vak").html(e)}})}function fillVakVerzaaid(){var e;e="getVakVerzaaid.php?perceelID="+$("#perceel").val(),console.log($("#perceel").val()),$.ajax({url:e,success:function(e){$("#vak").html(e)}})}function fillBoot(){var e;e="getBoot.php?bedrijfID="+$("#bedrijf").val(),console.log($("#boot").val()),$.ajax({url:e,success:function(e){$("#boot").html(e)}})}$(".date").datepicker({format:"dd-mm-yyyy",todayBtn:"linked",language:"nl"}),$(".date").datepicker({});