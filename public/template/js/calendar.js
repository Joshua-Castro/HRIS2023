(function($) {
  'use strict';
    $(function() {
        if ($('#calendar').length) {
            $('#calendar').fullCalendar({
                header      : {
                    left      : 'prev,next today',
                    center    : 'title',
                    right     : 'month,basicWeek,basicDay'
                },
                initialView     : 'dayGridMonth',
                defaultDate     :   '2017-07-18',
                navLinks        :   true,
                // draggable   :   false, // CAN GO TRUE OR FALSE DEPENDING ON THE USER ROLE IF ADMIN / USER
                editable        :   true,
                eventLimit      :   true,
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
                events : [{
                    title: 'All Day Event',
                    start: '2017-07-08'
                    },
                    {
                    title: 'Long Event',
                    start: '2017-07-01',
                    end: '2017-07-07',
                    description: 'This is an all-day event.',
                    color: '#FF5733'
                    },
                    {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2017-07-09T16:00:00',
                    end: '2017-07-09T19:00:00'
                    },
                    {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2017-07-16T16:00:00'
                    },
                    {
                    title: 'Conference',
                    start: '2017-07-11',
                    end: '2017-07-13'
                    },
                    {
                    title: 'Meeting',
                    start: '2017-06-26T07:30:00',
                    end: '2017-06-27T14:00:00'
                    },
                    {
                    title: 'Lunch',
                    start: '2017-07-12T12:00:00'
                    },
                    {
                    title: 'Meeting',
                    start: '2017-07-12T14:30:00'
                    },
                    {
                    title: 'Happy Hour',
                    start: '2017-07-12T17:30:00'
                    },
                    {
                    title: 'Dinner',
                    start: '2017-07-12T20:00:00'
                    },
                    {
                    title: 'Birthday Party',
                    start: '2017-07-13T07:00:00'
                    },
                    {
                    title: 'Click for Google',
                    url: 'http://google.com/',
                    start: '2017-07-28'
                    }
                ],
            })
        }
    });
})(jQuery);
