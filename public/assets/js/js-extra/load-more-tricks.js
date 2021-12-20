$(function(){

    const tricksLength = $('.tricks').length;
    const limit = 10;
    hideButton(tricksLength, limit);

    //hide tricks to limit
    $('.tricks').each(function(i){
        hideTricks($(this), i, limit)
    });

    //load more tricks click event
    $(document).on('click', '#load-more', function(){
        $('.tricks').show();
        $(this).text('Afficher moins');
        $(this).removeAttr('id');
        $(this).attr('id', 'load-less');    
    });

    //load less tricks click event
    $(document).on('click', '#load-less', function(){
        $('.tricks').each(function(i){
            hideTricks($(this), i, limit)
        });
        $(this).text('Voir plus');
        $(this).removeAttr('id');
        $(this).attr('id', 'load-more'); 
    })

    function hideTricks(trick, i, limit)
    {
        if(i + 1 > limit)
        {
            $(trick).hide();
        }
    }

    function hideButton(tricksLength, limit)
    {
        //hide button if tricks <= 10
        if(tricksLength <= limit)
        {
            $('#load-more').hide();
        }
        else{
            $('#load-more').show();
        }
    }

})