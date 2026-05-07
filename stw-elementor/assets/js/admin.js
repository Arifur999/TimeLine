/* Static Timeline Elementor – Admin JS */
(function($){
    $(document).on('click','.stw-upload-btn',function(e){
        e.preventDefault();
        var btn=$(this), tid=btn.data('target'), pid=btn.data('preview');
        wp.media({title:'Select Media',button:{text:'Use this'},multiple:false})
          .on('select',function(){
              var a=this.state().get('selection').first().toJSON();
              $('#'+tid).val(a.url);
              $('#'+pid).attr('src',a.url).show();
              btn.siblings('.stw-remove-btn').show();
          }).open();
    });
    $(document).on('click','.stw-remove-btn',function(e){
        e.preventDefault();
        var btn=$(this);
        $('#'+btn.data('target')).val('');
        $('#'+btn.data('preview')).attr('src','').hide();
        btn.hide();
    });
})(jQuery);
