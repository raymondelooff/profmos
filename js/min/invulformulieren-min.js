function fillVak(){var e;e="/ajax/getVak.php?perceelID="+$("#perceel").val(),$.ajax({url:e,success:function(e){$("#vak").html(e)}})}function fillVakVerzaaien(){var e;e="/ajax/getVakVerzaaien.php?perceelID="+$("#verzaaienPerceelSelect").val(),$.ajax({url:e,success:function(e){$("#verzaaienVak").html(e)}})}function fillBoot(){var e;e="/ajax/getBoot.php?bedrijfID="+$("#bedrijf").val(),$.ajax({url:e,success:function(e){$("#boot").html(e)}})}function toggleMonster(){"Ja"===$("#monster").val()?$("#labelDiv").show():$("#labelDiv").hide()}function toggleVerzaaien(){"Ja"===$("#verzaaien").val()?($("#verzaaienBedrijf").show(),$("#verzaaienPerceel").show(),$("#verzaaienVak").show(),$("#verzaaienOppervlakte").show()):"Nee"===$("#verzaaien").val()&&($("#verzaaienBedrijf").hide(),$("#verzaaienPerceel").hide(),$("#verzaaienVak").hide(),$("#verzaaienOppervlakte").hide())}$(document).ready(function(){toggleVerzaaien(),toggleMonster()}),$(".date").datepicker({format:"dd-mm-yyyy",todayBtn:"linked",language:"nl",calendarWeeks:!0,todayHighlight:!0});