Shopstr Database Structure

stores

id
store_name
slug
email
password
created_at

---

users

id
store_id
name
email
password
role

roles:

owner
admin
staff

---

categories

id
store_id
name

---

products

id
store_id
name
description
category_id

---

product_variants

id
product_id
size_id
color_id
barcode
cost_price
wholesale_price
retail_price

---

inventory

id
variant_id
quantity
updated_at

---

customers

id
store_id
name
phone
customer_type

customer_type:

retail
wholesale

---

orders

id
store_id
customer_id
total
status
created_at

status:

pending
paid
shipped
delivered

---

order_items

id
order_id
variant_id
quantity
price
