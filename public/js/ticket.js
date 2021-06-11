// $('#emp_name').on('change', function() {
//     var table = $('#ticket').DataTable();
//     table.column(5).search($(this).val()).draw();
// });
// $('#status').on('change', function() {
//     var table = $('#ticket').DataTable();
//     table.column(7).search($(this).val()).draw();
// });
// $('#priority').on('change', function() {
//     var table = $('#ticket').DataTable();
//     table.column(6).search($(this).val()).draw();
// });
// $(document).ready(function(){
//     $.fn.dataTable.ext.search.push(
//         function (settings, data, dataIndex) {
//             var min = $('#min').datepicker("getDate");
//             var max = $('#max').datepicker("getDate");
//             var startDate = new Date(data[5]);
//             if (min == null && max == null) { return true; }
//             if (min == null && startDate <= max) { return true;}
//             if(max == null && startDate >= min) {return true;}
//             if (startDate <= max && startDate >= min) { return true; }
//             return false;
//         }
//     );
//
//     $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
//     $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
//     var table = $('#ticket').DataTable();
//
//     // Event listener to the two range filtering inputs to redraw on input
//     $('#min, #max').change(function () {
//         table.draw();
//     });
// });
    $(document).ready(function() {
    if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
    var files = e.target.files,
    filesLength = files.length;
    for (var i = 0; i < filesLength; i++) {
    var f = files[i]
    var fileReader = new FileReader();
    fileReader.onload = (function(e) {
    var file = e.target;
    $("<div class=\"pip\">" +
    "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
    "<br/><div class=\"remove\"><i class='fa fa-remove'>Remove</div>" +
    "</div>").insertAfter("#files");
    $(".remove").click(function(){
    $(this).parent(".pip").remove("file");
});


});
    fileReader.readAsDataURL(f);
}
});
} else {
    alert("Your browser doesn't support to File API")
}
});
