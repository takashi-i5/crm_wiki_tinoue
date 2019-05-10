$(function() {
  'use strict';

  $('#new_word').focus();
  $('#new_meaning').focus();

  // delete
  $('#words').on('click', '.delete_word', function() {
    // idを取得
    var id = $(this).parents('li').data('id');
    // ajax処理
    if (confirm('are you sure?')) {
      $.post('_ajax.php', {
        id: id,
        mode: 'delete',
        token: $('#token').val()
      }, function() {
        $('#word_' + id).fadeOut(800);
      });
    }
  });

  // create meaning
  $('#new_word_form').on('submit', function() {
    console.log('submit');
    // titleを取得
    var word = $('#new_word').val();
    var meaning = $('#new_meaning').val();
    
    // ajax処理
    $.post('_ajax.php', {
      word: word,
      meaning: meaning,
      mode: 'create_word',
      token: $('#token').val()
    }, function(res) {
      // liを追加
      var $li = $('#word_template').clone();
      $li
        .attr('id', 'word_' + res.id)
        .data('id', res.id)
        .find('.word_title').text(word)
        .find('.meaning_title').text(meaning);
      $('#words').prepend($li.fadeIn());
      $('#new_word').val('').focus();
    });
    return false;
  });

  // update meaning
  $('#word_, #update_word_form').on('submit', function() {
    //console.log('update');
    //var meaning = $(this).children('#update_meaning').val();
    
    var id = $(this).parent('li').data('id');
    console.log(id);
    var meaning = $('#word_' + id).find('#update_meaning').val();
    console.log(meaning);

    $.post('_ajax.php', {
      id: id,
      meaning: meaning,
      mode: 'update',
      token: $('#token').val()
    }, function(res) {
      var $li = $('#word_template').clone();
      $li
        // .attr('id', 'word_')
        // .data('id', res.id)
        .find('.update_title').text(meaning);
      // $('#word' + id).fadeIn(2000);
      // $('#update_meaning').val('').focus();

      // $('#word_' + id).fadeOut(800);


    });
  });
});