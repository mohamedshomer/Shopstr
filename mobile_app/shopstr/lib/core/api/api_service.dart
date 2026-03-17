import 'dart:convert';
import 'package:http/http.dart' as http;
import '../storage/secure_storage.dart';
import '../constants/api_routes.dart';

class ApiService {

  // قراءة JWT من التخزين الآمن
  Future<String?> getToken() async {
    return await SecureStorage.read("jwt_token");
  }

  // حفظ JWT في التخزين الآمن
  Future<void> saveToken(String token) async {
    await SecureStorage.write("jwt_token", token);
  }

  // دالة GET
  Future<Map<String, dynamic>> get(String endpoint) async {
    final token = await getToken();
    final url = Uri.parse('${ApiRoutes.baseUrl}$endpoint');

    final response = await http.get(
      url,
      headers: {
        "Content-Type": "application/json",
        if (token != null) "Authorization": "Bearer $token",
      },
    );

    return _handleResponse(response);
  }

  // دالة POST
  Future<Map<String, dynamic>> post(String endpoint, Map<String, dynamic> body) async {
    final token = await getToken();
    final url = Uri.parse('${ApiRoutes.baseUrl}$endpoint');

    final response = await http.post(
      url,
      headers: {
        "Content-Type": "application/json",
        if (token != null) "Authorization": "Bearer $token",
      },
      body: jsonEncode(body),
    );

    return _handleResponse(response);
  }

  // دالة PUT
  Future<Map<String, dynamic>> put(String endpoint, Map<String, dynamic> body) async {
    final token = await getToken();
    final url = Uri.parse('${ApiRoutes.baseUrl}$endpoint');

    final response = await http.put(
      url,
      headers: {
        "Content-Type": "application/json",
        if (token != null) "Authorization": "Bearer $token",
      },
      body: jsonEncode(body),
    );

    return _handleResponse(response);
  }

  // دالة DELETE
  Future<Map<String, dynamic>> delete(String endpoint) async {
    final token = await getToken();
    final url = Uri.parse('${ApiRoutes.baseUrl}$endpoint');

    final response = await http.delete(
      url,
      headers: {
        "Content-Type": "application/json",
        if (token != null) "Authorization": "Bearer $token",
      },
    );

    return _handleResponse(response);
  }

  // التعامل مع Response
  Map<String, dynamic> _handleResponse(http.Response response) {
    final data = jsonDecode(response.body);

    if (response.statusCode >= 200 && response.statusCode < 300) {
      return data;
    } else {
      // يمكن إضافة logging هنا أو معالجة أخطاء خاصة
      throw Exception(data['message'] ?? 'خطأ في الاتصال بالخادم');
    }
  }

}
