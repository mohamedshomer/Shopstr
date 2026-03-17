import '../../../core/api/api_service.dart';
import '../../../core/constants/api_routes.dart';
import '../models/product_model.dart';

class ProductController {

  final api = ApiService();

  Future<List<ProductModel>> getProducts() async {
    final response = await api.get(ApiRoutes.getProducts);
    final data = response['data'] as List<dynamic>? ?? [];
    return data.map((e) => ProductModel.fromJson(e)).toList();
  }

  Future<bool> deleteProduct(int id) async {
    final response = await api.post(ApiRoutes.deleteProduct, {"id": id});
    return response['status']=="success";
  }

}
