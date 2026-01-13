$(document).ready(function () {
   // Setup CSRF token for AJAX requests
   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   function handleSidebarToggle() {
      // Remove any existing event handlers to avoid duplicates after resize
      $('#toggleBtn').off('click');
      $('.sidebar_backdrop').remove();

      if (window.matchMedia('(max-width: 992px)').matches) {
         // Functionality for screen size ≤ 992px
         $('#toggleBtn').click(function () {
            const sidebar = $('.sidebar_area');

            if (sidebar.is(':hidden')) {
               // Show sidebar
               sidebar.css('display', 'block');

               // Add backdrop
               const backdrop = $('<div class="sidebar_backdrop"></div>').appendTo('body');
               backdrop.fadeIn(200);

               // Close when backdrop clicked
               backdrop.click(function () {
                  sidebar.fadeOut(200);
                  backdrop.fadeOut(200, function () {
                     $(this).remove();
                  });
               });
            } else {
               // Hide sidebar
               sidebar.fadeOut(200);
               $('.sidebar_backdrop').fadeOut(200, function () {
                  $(this).remove();
               });
            }
         });
      } else {
         // Functionality for screen size > 992px
         $('#toggleBtn').click(function () {
            const sidebar = $('.sidebar_area');
            const main = $('.main_body_area');

            if (sidebar.is(':hidden')) {
               sidebar.css('display', 'block');
               main.css('width', 'calc(100% - 250px)');
            } else {
               sidebar.css('display', 'none');
               main.css('width', '100%');
            }
         });
      }
   }

   // Call the function when the script loads
   handleSidebarToggle();

   // Reapply function when resized
   $(window).resize(function () {
      handleSidebarToggle();
   });


   $('.closeBtn').click(function () {
      $('.sidebar_area').hide();
   });
   $('.openFrofile').click(function () {
      $('.owner_information_details').slideToggle();
   });
   // Toggle #msgBox on messageBtn click
   $('.messageBtn').click(function (e) {
      e.stopPropagation(); // Prevent event propagation
      $('#ntfBox').slideUp(); // Hide notification box if open
      $('#msgBox').slideToggle(); // Toggle message box
   });

   // Toggle #ntfBox on notificationBtn click
   $('.notificationBtn').click(function (e) {
      e.stopPropagation(); // Prevent event propagation
      $('#msgBox').slideUp(); // Hide message box if open
      $('#ntfBox').slideToggle(); // Toggle notification box
   });

   // Hide both boxes if clicked outside
   $(document).click(function (e) {
      if (!$(e.target).closest('#msgBox, .messageBtn, #ntfBox, .notificationBtn').length) {
         $('#msgBox, #ntfBox').slideUp(); // Hide both boxes
      }
   });

   // Real-time Toast Notification System
   let lastCheckTime = Date.now();
   const shownNotifications = new Set();

   function showToast(type, data) {
      console.log('showToast called:', type, data);

      // Create unique ID to prevent duplicates
      const notificationId = `${type}-${data.id}`;

      if (shownNotifications.has(notificationId)) {
         console.log('Toast already shown:', notificationId);
         return; // Already shown
      }

      shownNotifications.add(notificationId);

      let icon, title, message, typeClass;

      switch (type) {
         case 'subscriber':
            icon = '<i class="fas fa-envelope"></i>';
            title = 'New Subscription';
            message = `${data.email} subscribed to newsletter`;
            typeClass = 'toast-subscriber';
            break;
         case 'message':
            icon = '<i class="fas fa-comment-dots"></i>';
            title = 'New Message';
            message = `${data.name} sent you a message`;
            typeClass = 'toast-message';
            break;
         case 'application':
            icon = '<i class="fas fa-briefcase"></i>';
            title = 'New Job Application';
            message = `${data.name} applied for ${data.job_title || 'a position'}`;
            typeClass = 'toast-application';
            break;
         default:
            console.log('Unknown toast type:', type);
            return;
      }

      const timeAgo = 'Just now';

      const toastHtml = `
         <div class="realtime-toast ${typeClass}" data-notification-id="${notificationId}">
            <div class="toast-icon">${icon}</div>
            <div class="toast-content">
               <div class="toast-title">
                  ${title}
               </div>
               <p class="toast-message-text">${message}</p>
               <div class="toast-time">${timeAgo}</div>
            </div>
            <button class="toast-close" aria-label="Close">
               <i class="fas fa-times"></i>
            </button>
         </div>
      `;

      console.log('Creating toast element...');
      const $toast = $(toastHtml);
      console.log('Toast element created:', $toast);
      console.log('Appending to container...');
      $('#toast-container').append($toast);
      console.log('Toast appended! Container now has', $('#toast-container').children().length, 'children');

      // Auto-hide after 10 seconds
      const autoHideTimeout = setTimeout(function () {
         hideToast($toast);
      }, 10000);

      // Close button handler
      $toast.find('.toast-close').on('click', function () {
         clearTimeout(autoHideTimeout);
         hideToast($toast);
      });

      // Play notification sound (optional)
      playNotificationSound();
   }

   function hideToast($toast) {
      $toast.addClass('toast-hiding');
      setTimeout(function () {
         $toast.remove();
      }, 300);
   }

   function playNotificationSound() {
      // Optional: Play a subtle notification sound
      // You can add an audio file later if needed
      try {
         const audio = new Audio('/backend_assets/sounds/notification.mp3');
         audio.volume = 0.3;
         audio.play().catch(e => {}); // Silently fail if no audio file
      } catch (e) {
         // No audio file, ignore
      }
   }

   function checkForNewNotifications() {
      $.ajax({
         url: '/api/check-new-notifications',
         method: 'GET',
         data: { since: lastCheckTime },
         success: function (response) {
            console.log('Notification check response:', response);
            if (response.success) {
               // Show toasts for new subscribers
               if (response.data.subscribers && response.data.subscribers.length > 0) {
                  console.log('New subscribers:', response.data.subscribers);
                  response.data.subscribers.forEach(function (subscriber) {
                     showToast('subscriber', subscriber);
                  });
               }

               // Show toasts for new messages
               if (response.data.messages && response.data.messages.length > 0) {
                  console.log('New messages:', response.data.messages);
                  response.data.messages.forEach(function (message) {
                     showToast('message', message);
                  });
               }

               // Show toasts for new job applications
               if (response.data.applications && response.data.applications.length > 0) {
                  console.log('New applications:', response.data.applications);
                  response.data.applications.forEach(function (application) {
                     showToast('application', application);
                  });
               }

               // Update last check time
               lastCheckTime = Date.now();
            }
         },
         error: function (xhr, status, error) {
            console.error('Error checking notifications:', error, xhr.responseText);
         }
      });
   }

   // Check for new notifications every 15 seconds
   setInterval(checkForNewNotifications, 15000);

   // Initial check after 5 seconds
   setTimeout(checkForNewNotifications, 5000);

   // Make showToast available globally for testing
   window.testToast = function(type) {
      console.log('testToast called with type:', type);
      console.log('Toast container exists:', $('#toast-container').length);
      console.log('Toast container HTML:', $('#toast-container')[0]);

      const testData = {
         subscriber: { id: Math.random(), email: 'test@example.com' },
         message: { id: Math.random(), name: 'Test User' },
         application: { id: Math.random(), name: 'John Doe', job_title: 'Web Developer' }
      };
      showToast(type || 'message', testData[type] || testData.message);

      console.log('Toast appended. Container children:', $('#toast-container').children().length);
   };

   // Log that toast system is ready
   console.log('Toast notification system initialized.');
   console.log('Toast container found:', $('#toast-container').length > 0);
   console.log('Test with: testToast("message"), testToast("subscriber"), or testToast("application")');
});
