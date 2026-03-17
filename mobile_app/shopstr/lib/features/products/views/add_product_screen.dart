import 'package:flutter/material.dart';
import '../controllers/product_controller.dart';

class AddProductScreen extends StatefulWidget {
  const AddProductScreen({super.key});

  @override
  State<AddProductScreen> createState() => _AddProductScreenState();
}

class _AddProductScreenState extends State<AddProductScreen> {

  final _formKey = GlobalKey<FormState>();
  final ProductController controller = ProductController();

  final TextEditingController nameController = TextEditingController();
  final TextEditingController categoryController = TextEditingController();

  bool isLoading = false;

  void addProduct() async {
    if(!_formKey.currentState!.validate()) return;

    setState(() { isLoading = true; });

    // إرسال البيانات إلى API
    final response = await controller.api.post(
      '/products/add_product.php',
      {
        "name": nameController.text,
        "category_id": categoryController.text,
      }
    );

    setState(() { isLoading = false; });

    if(response['status']=="success"){
      Navigator.pop(context,true);
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(response['message'] ?? "Failed"))
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Add Product")),
      body: Padding(
        padding: EdgeInsets.all(16),
        child: Form(
          key: _formKey,
          child: Column(
            children: [
              TextFormField(
                controller: nameController,
                decoration: InputDecoration(labelText: "Product Name"),
                validator: (v)=> v==null || v.isEmpty ? "Enter product name" : null,
              ),
              TextFormField(
                controller: categoryController,
                decoration: InputDecoration(labelText: "Category ID"),
                validator: (v)=> v==null || v.isEmpty ? "Enter category ID" : null,
              ),
              SizedBox(height: 20),
              isLoading
                ? CircularProgressIndicator()
                : ElevatedButton(
                    onPressed: addProduct,
                    child: Text("Add Product"),
                  )
            ],
          ),
        ),
      ),
    );
  }
}
