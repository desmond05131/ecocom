document.addEventListener('DOMContentLoaded', function() {
  // Wait for the DOM to be fully loaded
  initializeCalendar();
});

/**
 * Initialize the FullCalendar instance
 */
function initializeCalendar() {
  // Get the calendar element
  const calendarEl = document.getElementById('calendar');

  // Exit if calendar element doesn't exist
  if (!calendarEl) {
    console.error('Calendar element not found');
    return;
  }

  // Sample recurring events data
  // In a real application, this would likely come from an API
  const recurringEvents = [
    {
      title: 'Klang Valley Recycling',
      daysOfWeek: [3], // Wednesday (0=Sunday, 1=Monday, etc.)
      startTime: '07:00:00',
      endTime: '09:00:00',
      startRecur: '2023-01-01',
      endRecur: '2023-12-31',
      extendedProps: {
        location: 'Jalan Teknologi 5, Taman Teknologi Malaysia, Kuala Lumpur',
        type: 'recycling',
        description: 'Weekly recycling program for paper, plastic, glass, and metal'
      }
    },
    {
      title: 'Gardening in Pavilion',
      daysOfWeek: [3], // Wednesday
      startTime: '07:00:00',
      endTime: '09:00:00',
      startRecur: '2023-01-01',
      endRecur: '2023-12-31',
      extendedProps: {
        location: 'Jalan Teknologi 5, Taman Teknologi Malaysia, Kuala Lumpur',
        type: 'gardening',
        description: 'Community gardening session led by Darren Tong'
      }
    },
    {
      title: 'Eco Swap Meet',
      daysOfWeek: [6], // Saturday
      startTime: '10:00:00',
      endTime: '14:00:00',
      startRecur: '2023-01-01',
      endRecur: '2023-12-31',
      extendedProps: {
        location: 'Community Center, Kuala Lumpur',
        type: 'community',
        description: 'Bring items to swap with other community members'
      }
    },
    {
      title: 'Composting Workshop',
      daysOfWeek: [0], // Sunday
      startTime: '15:00:00',
      endTime: '16:30:00',
      startRecur: '2023-01-01',
      endRecur: '2023-12-31',
      frequency: 'biweekly', // Custom property for display purposes
      extendedProps: {
        location: 'Urban Garden, Petaling Jaya',
        type: 'gardening',
        description: 'Learn how to create and maintain a compost system'
      }
    },
    {
      title: 'E-Waste Collection',
      daysOfWeek: [6], // Saturday
      startTime: '09:00:00',
      endTime: '12:00:00',
      startRecur: '2023-01-01',
      endRecur: '2023-12-31',
      frequency: 'monthly', // First Saturday of each month
      extendedProps: {
        location: 'Central Mall Parking Lot, Kuala Lumpur',
        type: 'recycling',
        description: 'Monthly collection of electronic waste for proper recycling'
      }
    }
  ];

  // Initialize FullCalendar
  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,listMonth'
    },
    events: recurringEvents,
    eventClassNames: function(arg) {
      // Add class based on event type
      return ['fc-event', `${arg.event.extendedProps.type}-event`];
    },
    eventClick: function(info) {
      showEventDetails(info.event);
    },
    eventTimeFormat: {
      hour: '2-digit',
      minute: '2-digit',
      meridiem: 'short'
    },
    firstDay: 1, // Start week on Monday
    height: 'auto',
    themeSystem: 'standard'
  });

  // Render the calendar
  calendar.render();
}

/**
 * Display event details in a popup when an event is clicked
 * @param {Object} event - The FullCalendar event object
 */
function showEventDetails(event) {
  // Create alert with event details
  const eventTime = event.startStr ? new Date(event.startStr).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) :
                   (event.startTime || 'All day');

  const details = `
    ${event.title}
    -----------------------------
    Time: ${eventTime} - ${event.endStr ? new Date(event.endStr).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : event.endTime}
    Location: ${event.extendedProps.location}
    Description: ${event.extendedProps.description}
  `;

  alert(details);

  // In a real application, you would show a modal dialog instead of an alert
  // For example:
  // showModal(event.title, event.extendedProps.location, event.extendedProps.description);
}

/**
 * Example function to show a modal with event details
 * This would be implemented with a proper modal component in a real application
 */
function showModal(title, location, description) {
  // This is just a placeholder for a real modal implementation
  console.log('Would show modal with:', { title, location, description });
}