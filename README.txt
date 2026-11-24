COASTLINE VILLA AND ROOM BOOKING SYSTEM
=======================================

TECHNOLOGIES
- HTML5, CSS3, JavaScript
- PHP 8+
- MySQL 5.7+ / MariaDB
- Apache (XAMPP recommended)

INSTALLATION (XAMPP)
1. Extract the folder "coastline_villa_booking_system" into:
   C:\xampp\htdocs\
2. Start Apache and MySQL from XAMPP Control Panel.
3. Open phpMyAdmin: http://localhost/phpmyadmin
4. Import database.sql.
   This creates the database "coastal_villa", three related tables,
   and three sample rooms.
5. Check config.php. The default XAMPP settings are:
   host=localhost, database=coastal_villa, user=root, password=(blank).
6. Open:
   http://localhost/coastline_villa_booking_system/

GUEST TEST
1. Register a guest account.
2. Login.
3. Open Availability, choose dates and guest count.
4. Select a room and submit the booking.
5. Open My Bookings to view or cancel a Pending booking.

ADMIN TEST
1. Register a normal account first.
2. In phpMyAdmin, run (use your registered email):
   UPDATE users SET role='admin' WHERE email='your-email@example.com';
3. Logout and login again.
4. Open Admin from the navigation.
5. Add/edit/deactivate rooms and confirm/cancel booking requests.

IMPORTANT NOTES
- Passwords are stored using PHP password_hash() and verified using
  password_verify().
- PHP sessions are used for login state.
- Prepared PDO statements are used for database queries.
- CSRF tokens are included in POST forms.
- The system blocks overlapping Pending or Confirmed room bookings.
- Booking totals are recalculated on the server, not trusted from the browser.
- This is an academic demonstration project. Add HTTPS, stronger deployment
  configuration, backups, email notifications and production testing before
  using it for real customer bookings.

PROJECT STRUCTURE
config.php
index.php
rooms.php
availability.php
gallery.php
location.php
register.php
login.php
logout.php
book.php
my-bookings.php
admin.php
admin-rooms.php
admin-bookings.php
database.sql
assets/style.css
assets/app.js
includes/header.php
includes/footer.php


NEW FEATURES ADDED
- Photo Gallery: gallery.php displays room, facility and surrounding-area photos. Click a photo to enlarge it. Photos are loaded from Unsplash, so an internet connection is required. Replace the sample photos with your own villa photos before final submission.
- Interactive Location Map: location.php embeds a Google map and provides a directions link.
- Homepage now links visitors to the gallery and location map.

SET YOUR REAL VILLA LOCATION
1. Open config.php in a code editor.
2. Find VILLA_MAP_QUERY near the bottom.
3. Replace 'Coastline Villa, Sri Lanka' with your real villa address or exact Google Maps place name.
4. Save the file and refresh location.php.

NEW PAGES
gallery.php  - Photo gallery with clickable enlarged images
location.php  - Interactive map and Google Maps directions
