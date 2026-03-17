import 'package:flutter/material.dart';
import '../controllers/product_controller.dart';
import '../models/product_model.dart';
import 'add_product_screen.dart';

class ProductsScreen extends StatefulWidget {
  const ProductsScreen({super.key});

  @override
  State<ProductsScreen> createState() => _ProductsScreenState();
}

class _ProductsScreenState extends State<ProductsScreen> {

  final ProductController controller = ProductController();

  bool isLoading = true;
  List<ProductModel> products = [];

  @override
  void initState() {
    super.initState();
    fetchProducts();
  }

  Future<void> fetchProducts() async {
    setState(() {
      isLoading = true;
    });

    try {
      products = await controller.getProducts();
    } catch (e) {
      print("Error fetching products: $e");
    }

    setState(() {
      isLoading = false;
    });
  }

  void deleteProduct(int id) async {
    bool confirmed = await showDialog(
      context: context,
      builder: (ctx) => AlertDialog(
        title: Text("Confirm Delete"),
        content: Text("Are you sure you want to delete this product?"),
        actions: [
          TextButton(onPressed: ()=> Navigator.pop(ctx,false), child: Text("Cancel")),
          TextButton(onPressed: ()=> Navigator.pop(ctx,true), child: Text("Delete")),
        ],
      )
    );

    if(confirmed){
      bool success = await controller.deleteProduct(id);
      if(success){
        fetchProducts();
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text("Product deleted successfully"))
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Products"),
        actions: [
          IconButton(
            icon: Icon(Icons.add),
            onPressed: () async {
              bool? added = await Navigator.push(
                context,
                MaterialPageRoute(builder: (_) => AddProductScreen())
              );
              if(added==true) fetchProducts();
            },
          )
        ],
      ),
      body: isLoading
        ? Center(child: CircularProgressIndicator())
        : products.isEmpty
          ? Center(child: Text("No products found"))
          : ListView.builder(
              itemCount: products.length,
              itemBuilder: (ctx, index){
                final product = products[index];
                return Card(
                  margin: EdgeInsets.all(8),
                  child: ListTile(
                    title: Text(product.name),
                    subtitle: Text("Category: ${product.categoryName}"),
                    trailing: Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        IconButton(
                          icon: Icon(Icons.edit),
                          onPressed: (){
                            // TODO: Edit product
                          },
                        ),
                        IconButton(
                          icon: Icon(Icons.delete),
                          onPressed: ()=> deleteProduct(product.id),
                        ),
                      ],
                    ),
                  ),
                );
              },
            ),
    );
  }
}
