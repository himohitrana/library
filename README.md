# Library Management System - Laravel Backend

A comprehensive library management system backend built with Laravel 11, featuring book rentals, sales, and user management.

## Features

### User Management
- User registration and authentication
- Role-based access control (Admin/User)
- Profile management
- Password reset functionality

### Book Management
- CRUD operations for books and categories
- Book cover image upload and processing
- Search and filtering capabilities
- Stock management
- Status tracking (available/rented/sold)

### Cart & Wishlist
- Shopping cart for both authenticated and guest users
- Wishlist functionality for registered users
- Support for both rental and purchase modes
- Rental duration selection

### Enquiry System
- Guest and user checkout system
- Enquiry creation from cart items
- Admin approval workflow
- Status tracking (new/reviewed/approved/rejected)

### Rental Management
- Convert approved enquiries to rentals
- Due date tracking
- Overdue rental detection
- Return processing

### Sales Management
- Convert approved enquiries to sales
- Stock management
- Sales tracking and statistics

### Admin Dashboard
- Comprehensive statistics
- Enquiry management
- Rental and sales overview

## Tech Stack

- **Framework**: Laravel 11
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel Sanctum
- **Authorization**: Spatie Laravel Permission
- **Image Processing**: Intervention Image
- **Storage**: Laravel Storage (local/public disk)

## Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL/MariaDB
- Node.js (for asset compilation, if needed)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd library-backend
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment configuration**
   ```bash
   cp .env.example .env
   ```
   
   Update the `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=library_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Create database**
   ```sql
   CREATE DATABASE library_management;
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the database**
   ```bash
   php artisan db:seed
   ```

8. **Create storage link**
   ```bash
   php artisan storage:link
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000/api`

## Default Users

After seeding, you can use these accounts:

### Admin Account
- **Email**: admin@library.com
- **Password**: password

### User Accounts
- **Email**: john@example.com, **Password**: password
- **Email**: jane@example.com, **Password**: password
- **Email**: bob@example.com, **Password**: password

## API Endpoints

### Authentication
- `POST /api/auth/register` - Register new user
- `POST /api/auth/login` - User login
- `POST /api/auth/logout` - User logout
- `GET /api/auth/user` - Get authenticated user
- `POST /api/auth/forgot-password` - Send password reset link
- `POST /api/auth/reset-password` - Reset password

### Categories
- `GET /api/categories` - Get all categories
- `POST /api/categories` - Create category (Admin)
- `PUT /api/categories/{id}` - Update category (Admin)
- `DELETE /api/categories/{id}` - Delete category (Admin)

### Books
- `GET /api/books` - Get books with search/filter
- `GET /api/books/{id}` - Get book details
- `POST /api/books` - Create book (Admin)
- `PUT /api/books/{id}` - Update book (Admin)
- `DELETE /api/books/{id}` - Delete book (Admin)

### Wishlist (Authenticated users only)
- `GET /api/wishlist` - Get user's wishlist
- `POST /api/wishlist/{book_id}` - Add book to wishlist
- `DELETE /api/wishlist/{book_id}` - Remove book from wishlist

### Cart (Supports guest users)
- `GET /api/cart` - Get cart items
- `POST /api/cart` - Add item to cart
- `PUT /api/cart/{id}` - Update cart item
- `DELETE /api/cart/{id}` - Remove cart item
- `DELETE /api/cart` - Clear cart

### Enquiries
- `POST /api/enquiries` - Create enquiry from cart
- `GET /api/enquiries` - Get enquiries (user: own, admin: all)
- `GET /api/enquiries/{id}` - Get enquiry details
- `PUT /api/enquiries/{id}` - Update enquiry status (Admin)

### Rentals
- `GET /api/rentals` - Get rentals (user: own, admin: all)
- `POST /api/rentals` - Create rental from enquiry (Admin)
- `PUT /api/rentals/{id}/return` - Mark rental as returned (Admin)

### Sales (Admin only)
- `GET /api/sales` - Get all sales
- `POST /api/sales` - Create sale from enquiry
- `GET /api/sales/{id}` - Get sale details

### Dashboard (Admin only)
- `GET /api/dashboard/stats` - Get dashboard statistics

## Query Parameters

### Books Endpoint
- `search` - Search in title, author, description
- `category` - Filter by category ID
- `status` - Filter by status (available/rented/sold)
- `sort` - Sort by field (title/author/price_sale/price_rent/created_at)
- `order` - Sort order (asc/desc)
- `per_page` - Items per page (default: 15)

### Example
```
GET /api/books?search=fiction&category=1&sort=title&order=asc&per_page=10
```

## Guest User Support

For guest users, include the `X-Guest-ID` header with a unique identifier:

```
X-Guest-ID: guest_12345
```

This allows guest users to:
- Add items to cart
- Create enquiries
- Maintain cart state across sessions

## File Uploads

Book cover images are uploaded to `storage/app/public/book-covers/` and automatically resized to 400x600 pixels while maintaining aspect ratio.

## Error Handling

The API returns consistent error responses:

```json
{
  "message": "Error description",
  "errors": {
    "field": ["Validation error message"]
  }
}
```

## Testing

Use the included Postman collection (`postman_collection.json`) to test all API endpoints.

## Database Schema

### Key Tables
- `users` - User accounts and profiles
- `categories` - Book categories
- `books` - Book inventory
- `wishlists` - User wishlists
- `carts` - Shopping cart items
- `enquiries` - Customer enquiries
- `rentals` - Book rentals
- `sales` - Book sales

## Security Features

- API authentication via Laravel Sanctum
- Role-based permissions
- Input validation
- CSRF protection
- Rate limiting
- Secure password hashing

## Performance Considerations

- Database indexing on frequently queried fields
- Eager loading to prevent N+1 queries
- Image optimization for book covers
- Pagination for large datasets

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).