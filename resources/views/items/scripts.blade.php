<script>
        $( function() {

            var elem = $('.color-picker')[0];
            var hueb = new Huebee( elem, {
              // options
            });        

            var availableTags = [
            <?php
                $supported = App\Item::supportedOptions();
                foreach($supported as $sapp) {
                    echo '"'.$sapp.'",';
                }
            ?>
            ];
            $( "#appname" ).autocomplete({
                source: availableTags,
                select: function( event, ui ) {
                    $.post('/appload', { app: ui.item.value }, function(data) {
                        $('#appimage').html("<img src='/storage/"+data.icon+"' /><input type='hidden' name='icon' value='"+data.icon+"' />");
                        $('input[name=colour]').val(data.colour);
                        hueb.setColor( data.colour );
                        $('input[name=pinned]').prop('checked', true);
                        if(data.config != null) {
                            $.get('/view/'+data.config, function(getdata) {
                                $('#sapconfig').html(getdata).show();
                            });
                        }
                    }, "json");
                }
            });
        });
</script>