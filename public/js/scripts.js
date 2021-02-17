$(".confirm").click(function(){
  var _t = $(this).data('text');
  if (!confirm(_t)) {
    return false;
  }
})
if ($(".custom-file-input").length > 0) {
  document.querySelector('.custom-file-input').addEventListener('change',function(e){
    var fileName = document.getElementById("photo").files[0].name;
    var nextSibling = e.target.nextElementSibling
    nextSibling.innerText = fileName
  })
}
if ($(".datepicker").length > 0) {
  setTimeout(()=>{
    $('.datepicker').daterangepicker({
      "locale": {
        "format": "DD/MM/YYYY HH:mm",
        "separator": " - ",
        "applyLabel": "Simpan",
        "cancelLabel": "Batal",
        "fromLabel": "Dari",
        "toLabel": "Sampai",
        "customRangeLabel": "Kustom",
        "daysOfWeek": [
          "Ahd",
          "Sen",
          "Sel",
          "Rab",
          "Kam",
          "Jum",
          "Sab"
        ],
        "monthNames": [
          "Januari",
          "Februari",
          "Maret",
          "April",
          "Mei",
          "Juni",
          "Juli",
          "Agustus",
          "September",
          "Oktober",
          "Nopember",
          "Desember"
        ],
        "firstDay": 0
      },
      "timePicker": true,
      "timePicker24Hour": true
    })
  },100)
}
if ($(".candidate").length > 0) {
  $(".candidate").click(function(){
    $(".candidate").removeClass('selected');
    $(this).addClass('selected');
    var _c = $(this).attr("id");
    $("#choice").val(_c);
    $("#fchoice").find('button[type="submit"]').prop('disabled',false);
  });

  $("#fchoice").submit(function(){
    if (!confirm("Yakin dengan pilihan Anda?")) {
      return false;
    }
  })
}
