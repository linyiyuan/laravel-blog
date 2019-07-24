/**
 * Particleground demo
 * @author Jonathan Nicol - @mrjnicol
 */

$(document).ready(function() {
  $('#particles').particleground({
    dotColor: '#CCFFFF',
    lineColor: '#CCFFFF'
  });
  $('.intro').css({
    'margin-top': -($('.intro').height() / 2)
  });
});