$(function(){$(".export-table").on("click",function(){var t=$(this).attr("data-export-table-id"),e=$("#"+t),o=e.clone();return $.each(e.find("tbody").find("tr:not(.active)"),function(){$(this).remove()}),e.tableExport({type:"excel",escape:"false"}),$("#"+t).html(o.html()),!1}),$(".toggle-active-row").on("change",function(){$(this).closest("tr").toggleClass("active")})});