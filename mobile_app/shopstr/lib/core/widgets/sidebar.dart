import 'package:flutter/material.dart';

class Sidebar extends StatelessWidget {

  final Function(String) onSelect;

  const Sidebar({super.key, required this.onSelect});

  Widget menuItem(String title) {
    return ListTile(
      title: Text(title, style: TextStyle(color: Colors.white)),
      onTap: () {
        onSelect(title);
      },
    );
  }

  @override
  Widget build(BuildContext context) {

    return Container(
      width: 220,
      color: Colors.black87,
      child: Column(
        children: [

          SizedBox(height: 40),

          Text(
            "SHOPSTR",
            style: TextStyle(
              color: Colors.white,
              fontSize: 22,
              fontWeight: FontWeight.bold
            ),
          ),

          SizedBox(height: 30),

          menuItem("Dashboard"),
          menuItem("Products"),
          menuItem("Categories"),
          menuItem("Customers"),
          menuItem("Invoices"),

        ],
      ),
    );

  }
}
