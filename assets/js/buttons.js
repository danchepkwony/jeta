const d = new Date();
d.setTime(d.getTime() + (30 * (24*60*60*1000)));
const expires = "expires="+ d.toUTCString();

(function($) {
    $(document).ready(() => {
        $('#translate').on("click", function(){
            var albanianText = $("[lang=sq]");
            var englishText = $("[lang=en]");
            if($(this)[0].checked){
                document.cookie = "copy_lang=en;" + expires + ";path=/";
                for(var text of albanianText){
                    text.style.display = "none";
                }
                for(var text of englishText){
                    text.style.display = "block";
                }
            }
            else{
                document.cookie = "copy_lang=sq;" + expires + ";path=/";                for(var text of englishText){
                    text.style.display = "none";
                }
                for(var text of albanianText){
                    text.style.display = "block";
                }
            }
        })

        $('#show-nav').on("click", function(){
            $('#mobile-nav')[0].style.display = "flex";
            window.scrollTo(0, 0);
            $('body')[0].style.overflowY = "hidden";
            $('body')[0].style.height = "100vh";
            setTimeout(() => {
                $('#mobile-nav')[0].style.transform = "translate3d(10px, 0, 0)";
            }, 50); 
        })

        $('#hide-nav').on("click", function(){
            $('#mobile-nav')[0].style.transform = "translate3d(calc(100% + 10px), 0, 0)";
            window.scrollTo(0, 0);
            $('body')[0].style.overflowY = "auto";
            $('body')[0].style.height = "auto";
            setTimeout(() => {
                $('#mobile-nav')[0].style.display = "none";
            }, 550); 
        })
    })
    $(window).on('load', function(){
        console.log(document.cookie);
        if(document.cookie.includes("copy_lang=en")){
            $('#translate')[0].checked = true;
            var albanianText = $("[lang=sq]");
            var englishText = $("[lang=en");
            for(var text of albanianText){
                text.style.display = "none";
            }
            for(var text of englishText){
                text.style.display = "block";
            }
        }
    })
})(jQuery);