class ApiRoutes {
  // ✨ القاعدة الأساسية للـ API
  static const String baseUrl =
      "https://ominous-fortnight-6v5q9q4qxvjcrxjp-8080.app.github.dev/"; //"http://127.0.0.1:8080";

  // -----------------------
  //Dashboard
  // -----------------------
  static const String dashboardStats = "$baseUrl/dashboard/get_stats.php";

  // -----------------------
  // Auth
  // -----------------------
  static const String registerStore = "/auth/register_store.php";
  static const String loginStore = "/auth/login_store.php";

  // -----------------------
  // Categories
  // -----------------------
  static const String addCategory = "/categories/add_category.php";
  static const String getCategories = "/categories/get_categories.php";
  static const String updateCategory = "/categories/update_category.php";
  static const String deleteCategory = "/categories/delete_category.php";

  // -----------------------
  // Products
  // -----------------------
  static const String addProduct = "/products/add_product.php";
  static const String getProducts = "/products/get_products.php";
  static const String updateProduct = "/products/update_product.php";
  static const String deleteProduct = "/products/delete_product.php";

  // -----------------------
  // Customers
  // -----------------------
  static const String addCustomer = "/customers/add_customer.php";
  static const String getCustomers = "/customers/get_customers.php";

  // -----------------------
  // Invoices
  // -----------------------
  static const String createInvoice = "/invoices/create_invoice.php";
  static const String getInvoices = "/invoices/get_invoices.php";
  static const String getInvoice = "/invoices/get_invoice.php";

  // -----------------------
  // Reports (optional)
  // -----------------------
  static const String dashboardStatsg = "/reports/dashboard_stats.php";
}
