            <footer class="main">
               &copy; <strong>Dhothar International</strong>
            </footer>
            <script>
            function checkNotification() {
               // Check current hour (in 24-hour format)
               const now = new Date();
               const currentHour = now.getHours(); // returns 0–23

               // Only run after 6 PM (18:00)
               if (currentHour >= 18) {
                  $.ajax({
                        url: 'attendance_system/notifications',
                        type: 'GET',
                        success: function(response) {
                           console.log("Received:", response);
                           try {
                              let data = typeof response === 'string' ? JSON.parse(response) : response;
                              if (data.status === 'new') {
                                    showSidebarNotification(data.message);
                              }
                           } catch (e) {
                              console.error("JSON parse error:", e);
                              console.log("Raw response:", response);
                           }
                        },
                        error: function(xhr, status, error) {
                           console.error("AJAX Error:", status, error);
                        }
                  });
               }
            }

            function showSidebarNotification(message) {
               let notification = $(`
                  <a href="attendance_dashboard" class="notification-popup" target="_blank">
                        ${message}
                  </a>
               `);
               $('body').append(notification);
               setTimeout(() => {
                  notification.fadeOut(300, function () { $(this).remove(); });
               }, 5000);
            }


            // Check every 10 seconds, but only runs if time is after 6 PM
            setInterval(checkNotification, 10000);
            </script>


            <style>
               .notification-popup {
                  position: fixed;
                  top: 75px;
                  right: 25px;
                  max-width: 400px;
                  background: linear-gradient(135deg, #ff4e50, #f44336);
                  color: #fff;
                  font-size: 16px;
                  font-weight: 500;
                  padding: 20px 24px;
                  border-radius: 12px;
                  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
                  z-index: 9999;
                  animation: slideInRight 0.4s ease-out;
                  display: flex;
                  align-items: center;
                  gap: 12px;
                  line-height: 1.4;
               }

               @keyframes slideInRight {
                  from {
                     opacity: 0;
                     transform: translateX(100%);
                  }
                  to {
                     opacity: 1;
                     transform: translateX(0);
                  }
               }

               /* Optional: Add icon styling if you're including icons inside the popup */
               .notification-popup i {
                  font-size: 22px;
                  flex-shrink: 0;
               }
            </style>
