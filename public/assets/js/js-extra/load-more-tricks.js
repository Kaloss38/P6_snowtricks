$(function(){

    const tricksLength = $('.tricks').length;
    //hide button if tricks <= 10
    if(tricksLength <= 10)
    {
        $('#load-more').hide();
    }
    else{
        $('#load-more').show();
    }

    const limit = 10;
    
    //hide tricks to limit
    $('.tricks').each(function(i){
        if(i + 1 > limit)
        {
            $(this).hide();
        }
    });

    //load more tricks click event
    $(document).on('click', '#load-more', function(){
        $('.tricks').show();
        $(this).text('Afficher moins')
        $(this).removeAttr('id');
        $(this).attr('id', 'load-less');    
    });

    //load less tricks click event
    $(document).on('click', '#load-less', function(){
        $('.tricks').each(function(i){
            if(i + 1 > limit)
            {
                $(this).hide();
            }
        });
        $(this).removeAttr('id');
        $(this).attr('id', 'load-more'); 
    })
})