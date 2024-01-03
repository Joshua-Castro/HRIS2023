(function($) {
    'use strict';

    $(function() {
        if ($('#calendar').length) {
            $('.calendar-spinner').removeAttr('hidden');
            $.ajax({
                type : "GET",
                url  : route('events'),
            }).then((response) => {
                const eventKey        =   Object.keys(response)[0];
                const events          =   response[eventKey] ? JSON.parse(atob(response[eventKey])) : "";

                $('#calendar').fullCalendar({
                    header      : {
                        left      : 'prev,next today',
                        center    : 'title',
                        right     : 'month,basicWeek,basicDay'
                    },
                    timezone        :   'UTC',
                    initialView     :   'dayGridMonth',
                    defaultDate     :   new Date(),
                    navLinks        :   true,
                    editable        :   false,
                    eventLimit      :   true,
                    events          :   events,
                    eventRender : function(event, element) {
                        // CREATE A WRAPPER ELEMENT TO HOLD THE EVENT TITLE AND DELETE BUTTON
                        var wrapper         = document.createElement('div');
                        wrapper.className   = 'event-wrapper';

                        // CREATE THE DELETE BUTTON ELEMENT
                        var deleteButton            =   document.createElement('span');
                        deleteButton.className      =   'delete-button me-2';
                        deleteButton.innerHTML      =   '❌';

                        // CREATE THE EVENT TITLE ELEMENT
                        var title           =   document.createElement('span');
                        title.className     =   'event-title';
                        title.innerHTML     =   event.title;

                        // APPEND THE DELETE BUTTON AND EVENT TITLE TO THE WRAPPER
                        wrapper.appendChild(deleteButton);
                        wrapper.appendChild(title);

                        // REPLACE THE EVENT'S CONTENT WITH THE WRAPPER
                        element.find('.fc-content').html(wrapper);

                        // HANDLE EVENT DELETION ON BUTTON CLICK
                        $(deleteButton).on('click', function() {
                          // HANDLE EVENT DELETION HERE (REMOVE THE EVENT).
                          // YOU'LL NEED TO MAKE AN AJAX REQUEST TO DELETE THE EVENT ON THE SERVER.
                          console.log('Event deleted:', event.title);
                          $('#calendar').fullCalendar('removeEvents', event._id); // REMOVE THE EVENT FROM THE CALENDAR.
                        });
                    },
                    // event1Color : '#3B71CA',
                })
                $('.spinner-container').attr('hidden', true);
            }).catch((error) => {

            });
        }
    });
})(jQuery);
