# Traveler Deals

A Laravel backend API for a delivery matchmaking platform connecting users who need items picked up with travelers heading to the same destination.

## Features

- User registration and authentication  
- Create products with weight and quantity  
- Define product categories  
- Manage restricted items that cannot be shipped  
- Manage delivery deals between users and travelers  
- Payment processing  
- Notifications system  

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/YourUserName/traveler-deals.git
   cd traveler-deals
   ```

2. Install PHP dependencies using Composer:
   ```bash
   composer install
   ```

3. Set up your environment variables:
   - Copy `.env.example` to `.env`
   - Configure your database and Mailtrap credentials inside `.env`

4. Run database migrations:
   ```bash
   php artisan migrate
   ```

5. Serve the application:
   ```bash
   php artisan serve
   ```

**Note:** You need to have [XAMPP](https://www.apachefriends.org/index.html) or similar local server environment installed with MySQL and PHP.

## Technologies Used

- Laravel 10  
- MySQL  
- Mailtrap for email testing  

## Contribution

Feel free to open issues or submit pull requests for improvements.

---

*This project is open source and licensed under the MIT License.*
