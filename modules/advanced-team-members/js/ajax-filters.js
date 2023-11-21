

// @codekit-prepend "../../../lib/select2/js/select2.full.js";

(function($) {


    var $form,
        $results_wrapper,
        $search_input;

    var spinner = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" id="spinner" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve"> <path opacity="0.2" fill="#fff" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"></path> <path fill="#fff" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z" transform="rotate(318.575 20 20)"> <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite"></animateTransform> </path> </svg>';


    function __init(){

       /**
        * Define Defaults
        */
        var timeout = null;
        $results_wrapper = $('#team__results'); 
        $search_input = $('#team_search_keyword')

       /**
        * Init Fancy Select
        */
       $('.select-submit2').select2();

       /**
        * Attach Event Handlers
        */

       if($search_input) {

            $search_input.on('keyup', function (e) {
               console.log('text change detected')
               clearTimeout(timeout);

               // Make a new timeout set to go off in 800ms
               timeout = setTimeout(function () {
                   load_team();
               }, 500);
           }); 
       }
       
       // prevent submit
       $form.on('submit', function(e){ e.preventDefault(); }); 

       $form.on('change', function(e) {
           e.preventDefault(); 

           // Skip if search input 
           if(e.target && e.target.id === 'team_search_keyword' ) return; 

           // Await finish and load
           clearTimeout(timeout);
           timeout = setTimeout(function () {
               load_team();
           }, 500);

       });
    }


    function load_team() {
        
        const form_data = $form.serialize(); 

        $.ajax({
            url: atm_ajax_object.ajax_url,
            dataType: 'html',
            type: 'POST',
            data: ({
                'action' : 'get_more_team_members',
                'ajax_security' : atm_ajax_object.ajax_nonce,
                'form_data' : form_data
            }),
            beforeSend: function(){
                
                //loading
                $results_wrapper.prepend('<div class="loading-overlay">' + spinner + '</div>');
            },
            success: function(data) {
                
                //loading
                $('.loading-overlay').remove();
                
                //append
                $results_wrapper.html(data); 
            },
            error: function(err){

                //loading
                $('.loading-overlay').remove();
                
                console.error(err);
                alert('An issue occured. Please try again later.')
            }

        });

    } 


    jQuery(document).ready(function($) {

        $form = $('#team__search__form'); 

        if($form){
            __init(); 
        }
    });

})(jQuery);