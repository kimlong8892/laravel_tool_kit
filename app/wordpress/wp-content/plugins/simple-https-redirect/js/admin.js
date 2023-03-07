;(function($) {



    // after document ready

    $(document).ready(function(){



    	// the radio change event

        $("[name='shr_force_type']").on("change", function() {

            $(".shr-radio").removeClass("checked");

            $("[name='shr_force_type']:checked").parents(".shr-radio").addClass("checked");

        });



        // radio division click updating the radio value

        $(".shr-radio").on("click", function() {

            $(this).find("input").prop("checked", true);

            $(".shr-radio").removeClass("checked");

            $("[name='shr_force_type']:checked").parents(".shr-radio").addClass("checked");

        });



    });



}(jQuery));