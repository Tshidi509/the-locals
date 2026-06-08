THE LOCALS REAL PROTOTYPE

1. Put this folder inside XAMPP htdocs.
2. Start Apache and MySQL.
3. Open phpMyAdmin.
4. Import schema.sql.
5. Visit: http://localhost/the-locals-real/index.php

Roles:
- Buyers can register, login, shop products, checkout, upload proof and track orders.
- Sellers can register, login, create only their own brand, add products, add payment details, pay R200 yearly subscription, and track their own sales.
- Admin can approve seller yearly subscriptions and see platform stats, but the admin dashboard does not show seller bank account numbers.

To create admin:
1. Register normally.
2. In phpMyAdmin run:
UPDATE users SET role='admin' WHERE email='your-email@example.com';

Security included:
- Passwords are hashed with password_hash.
- Role authorization protects seller, buyer and admin pages.
- Sellers cannot see other sellers dashboards/products/orders.
- Product uploads limited to 5 images per product and 3000 images per seller.

This is a realistic student prototype, not yet a fully production-ready marketplace.
