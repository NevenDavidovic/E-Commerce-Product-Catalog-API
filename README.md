# E-Commerce-Product-Catalog-API

# **Instructions for Setting Up the Application**

## **Prerequisites**

Before starting, ensure the following tools are installed on your system:

- **PHP 7.x or later**: Ensure PHP is installed by running `php -v` in your terminal.
- **MySQL or MariaDB**: Ensure you have a MySQL database setup and accessible.
- **Composer**: A dependency manager for PHP, required for installing necessary libraries. Check if Composer is installed by running `composer -v`.
- **Apache/Nginx** (Optional): For serving the PHP files if not using PHP's built-in server.
- **Git** (Optional): For cloning the repository.

---

## **Step 1: Cloning the Project**

If you're using Git, clone the repository to your local machine:

```bash
git clone https://github.com/your-repo-name.git
```

## **Step 2: Install Dependencies**

Navigate to the project directory where the composer.json file is located. Run Composer to install dependencies:

````
cd your-project-directory
composer install```
This will install all the required PHP libraries, including nikic/fast-route for routing.
````

## **Step 3: Setting up locally database backend\src\config**

Change $db_user , $db_password and $db_name with your database data.

## **Step 4: Running the API**

Move the cloned project folder into the htdocs directory of your XAMPP installation (e.g., C:\xampp\htdocs\).
Make sure Apache and MySQL are running in XAMPP Control Panel.
Navigate to the project's public folder (backend/public) in your browser:
URL: http://localhost/e-commerce-product-catalog-api/backend/public/

Once XAMPP is running and Apache/MySQL are active, you can access the API using the browser(frontend side of the app) or Postman.

## **API Endpoints**

### **Product Endpoints**

1. **GET /products**

   - **Description**: Retrieves a list of all available products.
   - **Additional Features**: Supports query parameters for filtering products by category, price range, or search term (e.g., `?category=1`, `?search=smartphone`).
   - **Response**: Returns an array of product objects, including their attributes and associated category.

2. **GET /products/{sku}**

   - **Description**: Retrieves the details of a specific product by its SKU (Stock Keeping Unit).
   - **Parameters**:
     - `sku`: The unique identifier of the product.
   - **Response**: Returns a single product object with detailed information.

3. **POST /products**

   - **Description**: Creates a new product in the catalog.
   - **Request Body**: Expects a JSON object with the product details, including `sku`, `name`, `description`, `price`, `type`, `category_id`, and `image_url`.
   - **Response**: Returns the created product object with the generated ID.

4. **PUT /products/{sku}**

   - **Description**: Updates the details of an existing product by its SKU.
   - **Parameters**:
     - `sku`: The unique identifier of the product.
   - **Request Body**: Expects a JSON object with the fields to update, such as `name`, `price`, or `description`.
   - **Response**: Returns the updated product object.

5. **DELETE /products/{sku}**
   - **Description**: Deletes a specific product from the catalog by its SKU.
   - **Parameters**:
     - `sku`: The unique identifier of the product.
   - **Additional Features**: Ensures foreign key constraints are respected; if the product has associated attributes, the deletion may fail unless attributes are deleted first.
   - **Response**: Returns a success message or an error if constraints prevent deletion.

---

### **Category Endpoints**

1. **GET /categories**

   - **Description**: Retrieves a list of all product categories.
   - **Response**: Returns an array of category objects, each containing an `id` and `name`.

2. **GET /categories/{id}**
   - **Description**: Retrieves details of a specific category by its ID.
   - **Parameters**:
     - `id`: The unique identifier of the category.
   - **Response**: Returns a single category object with detailed information.

---

## **Additional Features**

- **Search and Filtering**:

  - The **GET /products** endpoint supports query parameters for filtering products by category, name, or price range.
  - **Examples**:
    - `/products?category=1` - Filters products by category.
    - `/products?search=laptop` - Searches products by name or description.
    - `/products?min_price=100&max_price=500` - Filters products within a specific price range.

- **Attributes**:
  - Each product can have associated attributes (e.g., color, shipping price). Attributes are stored in a separate table and linked to the product via a foreign key.
  - Product attributes can be returned along with product data in the **GET /products** and **GET /products/{sku}** endpoints.

---

# Screenshots of usage of the App
![image](https://github.com/user-attachments/assets/f78892d2-ae06-4acc-85da-13429221dd65)
![image](https://github.com/user-attachments/assets/2f234a0d-54dd-4273-9f9d-278df31b0e34)


