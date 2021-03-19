$(document).ready(function(){
    //animation mdbootstap
    new WOW().init();

/*
---------------------------
debut Gestion du sidebar
---------------------------
*/

    $('.closebtn').click(function(){
        openNav();
    })

    $('.closebtn').click(function(){
        closeNav();
    });

    $('.open').click(function(){
        openNav();
    });
   
    //fonction permettant d'ouvrir le sidebar
    function openNav() {
        $('#sidenav').css('width','250px');
        $('.open').css('display','none');
      }
      
    //fonction permettant de fermer le sidebar
    function closeNav() {
        $('#sidenav').css('width','0');
        $('.open').css('display','');
    }
    
/*
---------------------------
fin Gestion du sidebar
---------------------------
*/
    
    











})