<script src="<?= base_url("assets") ?>/vendors/bower_components/searchable/searchable.js"></script>
<script>




    $(".search__text").focus();

    $('#yeah').searchable({
        searchField: '.search__text',
        selector: '.aplikasi',
        childSelector: '.applabel p',
        show: function (elem) {
            elem.slideDown(100);
        },
        hide: function (elem) {
            elem.slideUp(100);
        }
    })


<?php
if ($this->input->get("login") == "true") {
    ?>
        $("#login").click();

        $("#password").focus();

    <?php
}
?>


<?php
if (session("username") != "") {
    ?>
        $(".star").click(function () {
            var app_id = $(this).attr("app_id");
            var pin = $(this).attr("pin");
            
            console.log(pin);
            
            if(pin == 1){
                $(this).find("img").attr("src","<?=base_url("assets/star-icon2.png")?>");
                $(this).attr("pin", 0);
            }else {
                 $(this).find("img").attr("src","<?=base_url("assets/star-icon.png")?>");
                  $(this).attr("pin", 1);
            }
            
            

       

            $.ajax({
                type: "post",
                data: {app_id: app_id},

                url: "<?= site_url("home/pin") ?>",
                success: function (msg) {

 console.log(msg);
                   


                }, error: function (msg) {

                    console.log(msg);

                }
            });


        });



    <?php
}
?>

</script>