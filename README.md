Plant Shop - Online Nursery
===========================

Project Overview:
-----------------
This is an online plant nursery website where users can browse various plant categories, view product details, and add items to their cart.

Installation Instructions:
--------------------------
1. Install a local server environment (XAMPP, WAMP, or MAMP).
2. Place the project folder inside the "htdocs" directory (for XAMPP).
3. Import the database:
   - Open phpMyAdmin.
   - Create a new database named `plant_shop`.
   - Import the `plant_shop.sql` file (if available).
4. Update the database connection:
   - Open `includes/conn.php`.
   - Modify the database credentials if needed.

Technologies Used:
------------------
- PHP
- MySQL
- Bootstrap (for styling)
- Font Awesome (icons)
- JavaScript (for interactivity)

Project Structure:
------------------
- `index.php` - Home page
- `category.php` - Lists plant categories
- `products.php?id=XX` - Displays product details
- `cart.php` - Shopping cart functionality
- `login.php`, `logout.php` - User authentication
- `add_to_cart.php` - Adds products to the cart
- `includes/conn.php` - Database connection file
- `css/style.css` - Stylesheet
- `get_image.php` - Fetches images fr

Future Improvements:
--------------------
- Add payment gateway integration.
- Implement user reviews & ratings.
- Improve search functionality.



















