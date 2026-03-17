import 'package:get/get.dart';
import '../../../core/api/api_service.dart';
import '../../../core/constants/api_routes.dart';

class DashboardController extends GetxController {

  var products = 0.obs;
  var categories = 0.obs;
  var customers = 0.obs;

  @override
  void onInit() {
    loadStats();
    super.onInit();
  }

  void loadStats() async {
    final api = ApiService();
    var response = await api.get(ApiRoutes.dashboardStats);

    if(response["status"] == "success"){

      products.value = response["data"]["products"];
      categories.value = response["data"]["categories"];
      customers.value = response["data"]["customers"];

    }

  }

}