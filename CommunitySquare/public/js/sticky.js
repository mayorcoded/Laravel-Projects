window.requestAnimationFrame = window.requestAnimationFrame
    || window.mozRequestAnimationFrame
    || window.webkitRequestAnimationFrame
    || window.msRequestAnimationFrame
    || function(f){return setTimeout(f, 1000/60)}
 
 
;(function($){ // enclose everything in a immediately invoked function to make all variables and functions local
 
    var $body,
    $target,
    targetoffsetTop,
    resizetimer,
    stickyclass= 'sticky' //class to add to BODY when header should be sticky
     
    function updateCoords(){
        targetoffsetTop = $target.offset().top
    }
     
    function makesticky(){
        var scrollTop = $(document).scrollTop()
        if (scrollTop >= targetoffsetTop){
            if (!$body.hasClass(stickyclass)){
                $body.addClass(stickyclass)
            }
        }
        else{
            if ($body.hasClass(stickyclass)){
                $body.removeClass(stickyclass)
            }
        }
    }
     
    $(window).on('load', function(){
        $body = $(document.body)
        $target = $('#header')
        updateCoords()
        $(window).on('scroll', function(){
            requestAnimationFrame(makesticky)
        })
        $(window).on('resize', function(){
            clearTimeout(resizetimer)
            resizetimer = setTimeout(function(){
                $body.removeClass(stickyclass)
                updateCoords()
                makesticky()
            }, 50)
        })
    })
 
})(jQuery)