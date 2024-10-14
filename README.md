# E-Commerce-Product-Catalog-API

project_root/
│
├── public/
│ └── index.php # Entry point for all requests
│
├── src/
│ ├── Config/
│ │ └── Database.php # Database connection configuration
│ │
│ ├── Controllers/
│ │ └── ProductController.php # Controller for product-related operations
│ │ └── CategoryController.php # Controller for category-related operations
│ │
│ ├── Models/
│ │ └── Product.php # Product model
│ │ └── Category.php # Category model
│ │ └── Attribute.php # Attribute model
│ │
│ ├── Services/
│ │ └── ProductService.php # Service for business logic related to products
│ │ └── CategoryService.php # Service for business logic related to categories
│ │
│ └── Router.php # Custom router class
│
├── vendor/ # Composer dependencies (if used)
│
└── .htaccess # Apache configuration for URL rewriting
