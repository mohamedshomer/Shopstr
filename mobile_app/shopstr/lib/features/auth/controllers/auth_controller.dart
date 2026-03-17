import 'dart:convert';
import 'package:get/get.dart';
import 'package:http/http.dart' as http;
import 'package:shopstr/features/auth/models/user_model.dart';
import 'package:shopstr/features/dashboard/views/dashboard_screen.dart';

class AuthController extends GetxController {
  var isLoading = false.obs;

Future<UserModel?> login(String slug, String password) async {
  try {
    isLoading.value = true;

    var url = Uri.parse(
      "https://ominous-fortnight-6v5q9q4qxvjcrxjp-8080.app.github.dev/login.php",
    );

    var response = await http.post(
      url,
      body: {"slug": slug, "password": password},
    );

    var data = jsonDecode(response.body);

    UserModel result = UserModel.fromJson(data);

    if (result.status == "success") {
      Get.snackbar("Success", result.message);

      // 🔥 Navigate to Dashboard
      Get.offAll(() => DashboardScreen());

      print(result);

      return result;
    } else {
      Get.snackbar("Error", result.message);
      return null;
    }

  } catch (e) {
    Get.snackbar("Error", e.toString());
    return null;

  } finally {
    isLoading.value = false; // ✅ always runs
  }

  // ✅ required fallback
  return null;
}
}
