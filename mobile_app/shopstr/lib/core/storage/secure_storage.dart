import 'package:flutter_secure_storage/flutter_secure_storage.dart';

class SecureStorage {

  // إنشاء مثيل للتخزين الآمن
  static final _storage = FlutterSecureStorage();

  // كتابة قيمة
  static Future<void> write(String key, String value) async {
    await _storage.write(key: key, value: value);
  }

  // قراءة قيمة
  static Future<String?> read(String key) async {
    return await _storage.read(key: key);
  }

  // حذف قيمة
  static Future<void> delete(String key) async {
    await _storage.delete(key: key);
  }

  // حذف كل القيم
  static Future<void> deleteAll() async {
    await _storage.deleteAll();
  }

}
