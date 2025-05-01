# Laravel E-commerce API

A simple e-commerce API built with Laravel, featuring user management, product catalog, and order processing.

## Requirements
- PHP >= 8.2
- Composer
- MySQL
- Laravel 12.x
- Postman (for testing)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/ixmsanto/laravel-ecommerce-db.git
cd laravel-ecommerce
```

2. Install dependencies:
```bash
composer install
```

3. Copy the environment file and configure:
```bash
cp .env.example .env
```

4. Update `.env` with your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_ecommerce
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Run migrations and seed the database:
```bash
php artisan migrate
php artisan db:seed
```

7. Start the development server:
```bash
php artisan serve
```

The API will be available at `http://localhost:8000`.

## Database Structure
- `users`: Stores user information (id, name, email, password, role)
- `products`: Stores product details (id, name, description, price, stock)
- `orders`: Stores order information (id, user_id, total_price, status)
- `order_items`: Stores order item details (id, order_id, product_id, quantity, price)

## MySQL Queries
The raw MySQL queries used in the API are available in the `ecommerce_queries.sql` file in the project's root directory. These include:
- Fetching products with stock > 10
- Fetching orders for a specific user
- Updating product stock after an order

You can execute these queries directly in your MySQL client, replacing placeholders (e.g., `:user_id`, `:order_id`) with actual values.

## API Endpoints
- `GET /api/products/high-stock`: Get products with stock > 10
- `GET /api/users/{userId}/orders`: Get all orders for a specific user
- `POST /api/orders`: Create a new order and update product stock

## Testing with Postman

1. Import the following Postman collection:
```json
{
    "info": {
        "name": "Laravel E-commerce API",
        "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
    },
    "item": [
        {
            "name": "Get High Stock Products",
            "request": {
                "method": "GET",
                "header": [],
                "url": {
                    "raw": "{{baseUrl}}/api/products/high-stock",
                    "host": ["{{baseUrl}}"],
                    "path": ["api", "products", "high-stock"]
                }
            }
        },
        {
            "name": "Get User Orders",
            "request": {
                "method": "GET",
                "header": [],
                "url": {
                    "raw": "{{baseUrl}}/api/users/1/orders",
                    "host": ["{{baseUrl}}"],
                    "path": ["api", "users", "1", "orders"]
                }
            }
        },
        {
            "name": "Place Order",
            "request": {
                "method": "POST",
                "header": [
                    {
                        "key": "Content-Type",
                        "value": "application/json"
                    }
                ],
                "body": {
                    "mode": "raw",
                    "raw": "{\n    \"user_id\": 1,\n    \"items\": [\n        {\n            \"product_id\": 1,\n            \"quantity\": 2\n        },\n        {\n            \"product_id\": 2,\n            \"quantity\": 1\n        }\n    ]\n}"
                },
                "url": {
                    "raw": "{{baseUrl}}/api/orders",
                    "host": ["{{baseUrl}}"],
                    "path": ["api", "orders"]
                }
            }
        }
    ]
}
```

2. Set up Postman environment:
```json
{
    "name": "Laravel E-commerce",
    "values": [
        {
            "key": "baseUrl",
            "value": "http://localhost:8000",
            "type": "default",
            "enabled": true
        }
    ]
}
```

3. Test the endpoints:
- **Get High Stock Products**: Returns products with stock > 10
- **Get User Orders**: Replace `1` with a valid user ID from your database
- **Place Order**: Ensure `user_id` and `product_id` exist in the database

## Running Tests
1. Check the seeded data in your MySQL database
2. Use Postman to test the endpoints
3. Verify stock updates after placing orders
4. Optionally, run the queries in `ecommerce_queries.sql` manually in your MySQL client to test raw query behavior

## Contributing
1. Fork the repository
2. Create a feature branch
3. Submit a pull request

## License
MIT License
