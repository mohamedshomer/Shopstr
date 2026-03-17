class ProductModel {
  final int id;
  final String name;
  final String categoryName;

  ProductModel({
    required this.id,
    required this.name,
    required this.categoryName,
  });

  factory ProductModel.fromJson(Map<String, dynamic> json){
    return ProductModel(
      id: int.parse(json['id'].toString()),
      name: json['name'] ?? '',
      categoryName: json['category_name'] ?? '',
    );
  }
}
