</div>
<!-- ./wrapper -->
<script src="<?php echo LTE;?>plugins/sweetalert/sweetalert.min.js"></script>

<!------Mentioned lte url globally(for tinymce)------>
<script>var lte_url = "<?php echo LTE; ?>";</script>

<script src="<?php echo LTE;?>custom/custom.js"></script>
<script>
    var fullUrl = $(location).attr('href');
    var urlArray = fullUrl.split('/');
    var urlLength = urlArray.length;
    var currentMenu = urlArray[urlLength-1];
    var currentMenu2 = urlArray[urlLength-2] + '/' + currentMenu;
    var currentMenu3 = urlArray[urlLength-3] + '/' + currentMenu2;
    $('.sidebar-menu a').each(function(){
        if(typeof(pageHighlightMenu) != 'undefined')
            currentMenu = pageHighlightMenu;

        var currentHrefUri = $(this).attr('href');
        var currentHrefUri = currentHrefUri.split("index.php/");
        if(currentHrefUri[1] == currentMenu || currentHrefUri[1] == currentMenu2 || currentHrefUri[1] == currentMenu3){
        var parent = $(this).parent().parent();
        if(parent.is('ul') && !parent.hasClass('sidebar-menu')){
            $(this).parent().addClass('active')
            parent.parent().addClass('active');
            parent.show();
        }
        else if($(this).parent().is('li')){
            $(this).parent().addClass('active');
        }
        }
    });
</script>
</body>
</html>