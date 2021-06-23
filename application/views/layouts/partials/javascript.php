<script type="text/javascript">
  // -------------------------------
  // Back to Top button
  // -------------------------------
  $(document).on('click', '#back-to-top', function(e) {
    $('body,html').animate({
      scrollTop: 0
    }, 500);
    return false;
  });

  $(document).on('keyup keypress', '.toUpperCase', function() {
    this.value = this.value.toUpperCase();
  });

  function updateClock() {
    function pad(n) {
      return (n < 10) ? '0' + n : n;
    }
    var weekday = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    var now = new Date();
    var s = pad(weekday[now.getDay()]) + ', ' +
      pad(now.getDate()) + '/' +
      pad(now.getMonth() + 1) + '/' +
      pad(now.getFullYear()) + ' ' +
      pad(now.getHours()) + ':' +
      pad(now.getMinutes()) + ':' +
      pad(now.getSeconds()) + ' WIB';

    $('#showtime').html(s);
    var delay = 1000 - (now % 1000);
    setTimeout(updateClock, delay);
  }

  function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return parts.join(",");
  }

  /**
   * Date Picker
   */
  $.fn.datepicker.defaults.format = "yyyy-mm-dd";
  $.fn.datepicker.defaults.setDate = new Date();
  $('.datepicker').datepicker({
    "setDate": new Date(),
    "autoclose": true
  });


  $(document).on('click', '.btnFilter', function(e) {
    $('#formFilter').slideToggle('slow');
  });
  
</script>