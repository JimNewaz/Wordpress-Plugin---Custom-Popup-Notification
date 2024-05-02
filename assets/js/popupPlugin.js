// jQuery(document).ready(function($) {
//     $('.popup-modal').hide(); 

    
//     // Function to show the popup after a delay
//     function showPopup() {
//         $('.popup-modal').fadeIn(300); // Adjust the transition speed as needed
//     }

//     // Function to hide the popup after a delay
//     function hidePopup() {
//         $('.popup-modal').fadeOut(300); // Adjust the transition speed as needed
//     }

//     // Show the popup after 20 seconds
//     setTimeout(showPopup, 20000);

//     // Hide the popup after 40 seconds if the user hasn't closed it
//     setTimeout(hidePopup, 40000);

//     // Function to handle subsequent popups after intervals
//     function schedulePopup() {
//         setTimeout(function() {
//             showPopup();
//             setTimeout(hidePopup, 40000);
//             schedulePopup(); // Schedule the next popup
//         }, 60000); // 20 seconds for display + 40 seconds for hiding
//     }

//     // Call the schedulePopup function to start the sequence
//     schedulePopup();

//     // Hide the popup on close button click
//     $('.close-button').click(function() {
//         hidePopup();
//     });

//     // Hide the popup on close button click
//     $('.close-button').click(function() {
//         $('.popup-modal').fadeOut(300); // Adjust the transition speed as needed
//     });

// });


// jQuery(document).ready(function($) {
//     $('.popup-modal').hide();

//     // Function to show the popup after a delay
//     function showPopup() {
//         $('.popup-modal').fadeIn(300); // Adjust the transition speed as needed
//     }

//     // Function to hide the popup after a delay
//     function hidePopup() {
//         $('.popup-modal').fadeOut(300); // Adjust the transition speed as needed
//     }

//     // Show the popup after the specified delay
//     setTimeout(showPopup, custom_ajax_object.popupDelay * 1000); // Multiply by 1000 to convert seconds to milliseconds

//     // Function to handle subsequent popups after intervals
//     function schedulePopup() {
//         setTimeout(function() {
//             showPopup();
//             setTimeout(function() {
//                 hidePopup();
//                 schedulePopup(); 
//             }, custom_ajax_object.popupInterval * 1000); // Multiply by 1000 to convert seconds to milliseconds
//         }, custom_ajax_object.popupDelay * 1000); // Multiply by 1000 to convert seconds to milliseconds
//     }

//     // Call the schedulePopup function to start the sequence
//     schedulePopup();

//     // Hide the popup on close button click
//     $('.close-button').click(function() {
//         hidePopup();
//     });
// });


jQuery(document).ready(function($) {
    $('.popup-modal').hide();
    var popups = $('.popup-modal');
    var popupDelay = custom_ajax_object.popupDelay * 1000; 
    var popupDuration = custom_ajax_object.popupDuration * 1000; 
    var popupInterval = custom_ajax_object.popupInterval * 1000; 
    var currentIndex = 0;

    function showPopup(index) {
        if (currentIndex === popups.length) {
            $('.popup-modal').fadeOut(300);
            return;
        }

      
        $('.popup-modal').fadeOut(1000);

        
        popups.eq(index).fadeIn(1000);

        
        setTimeout(function() {
          
            popups.eq(index).fadeOut(1000);

           
            currentIndex++;

           
            if (currentIndex < popups.length) {
                setTimeout(function() {
                    showPopup(currentIndex);
                }, popupInterval);
            }
        }, popupDuration);
    }

   
    setTimeout(function() {
        showPopup(currentIndex);
    }, popupDelay);
    
    
    $('.close-button').click(function() {
        $('.popup-modal').hide();
    });
});