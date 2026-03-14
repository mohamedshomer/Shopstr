backend_api
│
├── db.php                   # الاتصال بقاعدة البيانات
├── api_helper.php           # الدوال العامة CRUD + JWT
│
├── auth
│   ├── jwt_helper.php
│   ├── register_store.php
│   └── login_store.php
│
├── stores
│   └── get_store.php
│
├── categories
│   ├── add_category.php
│   ├── get_categories.php
│   ├── update_category.php
│   └── delete_category.php
│
├── products
│   ├── add_product.php
│   ├── get_products.php
│   ├── update_product.php
│   └── delete_product.php
│
├── variants
│   ├── add_variant.php
│   ├── get_variants.php
│   └── delete_variant.php
│
├── customers
│   ├── add_customer.php
│   ├── get_customers.php
│   └── update_customer.php
│
├── users
│   ├── add_user.php
│   ├── get_users.php
│   ├── update_user.php
│   ├── delete_user.php
│   └── login_user.php
│
├── invoices
│   ├── create_invoice.php
│   ├── get_invoices.php
│   └── get_invoice.php
│
├── inventory
│   ├── update_stock.php
│   └── get_inventory.php
│
├── payments
│   └── get_payments.php
│
├── cashbox
│   └── get_cashbox.php
│
├── reports
│   ├── sales.php
│   ├── inventory.php
│   ├── customers.php
│   └── invoices.php
│
└── utils
    └── upload_image.php
