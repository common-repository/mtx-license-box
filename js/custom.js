jQuery(document).ready(function($){
   $('.ylb-close').click(function(){
       switch(effectType)
       {
           case 'slideup':
           $(this).parent().slideUp('slow');
           break;
           
           case 'fadeout':
           $(this).parent().fadeOut('slow');
           break;
           
           default:
           $(this).parent().slideUp('slow');
       }
       return false;
   });    
});