// form validation
//jQuery("#step_2").validationEngine();
jQuery("#step_2").validationEngine('attach', {promptPosition : "bottomLeft", scroll: true, showArrowOnRadioAndCheckbox:true});
jQuery("#step_3").validationEngine('attach', {promptPosition : "topRight", scroll: true, showArrowOnRadioAndCheckbox:true});
jQuery("#update_user_profile").validationEngine('attach', {promptPosition : "topLeft", scroll: true, showArrowOnRadioAndCheckbox:true});
jQuery("#register-customer").validationEngine('attach', {promptPosition : "topLeft", scroll: false, showArrowOnRadioAndCheckbox:true});
jQuery("#update_booking_1").validationEngine('attach', {promptPosition : "bottomLeft", scroll: true, showArrowOnRadioAndCheckbox:true});
jQuery("#step_1").validationEngine('attach', {promptPosition : "bottomLeft", scroll: true, showArrowOnRadioAndCheckbox:true});