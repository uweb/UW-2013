$(document).ready(function() {

  $('.communityphotos').each(function() {
    $(this)
      .find('img')
      .each(function() {
        var $this = $(this);
        $this.attr('src', $this.data('src'));
      })
  })

});
