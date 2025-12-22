import 'dart:convert';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:vanstock_mobile/features/auth/data/models/auth_models.dart';

/// Session Storage Service
/// خدمة حفظ الجلسة
class SessionStorage {
  static const FlutterSecureStorage _storage = FlutterSecureStorage();
  
  // Keys
  static const String _tokenKey = 'auth_token';
  static const String _userKey = 'user_data';
  static const String _salesRepKey = 'sales_rep_data';
  static const String _isLoggedInKey = 'is_logged_in';
  
  // ============ Token Management ============
  
  static Future<void> saveToken(String token) async {
    await _storage.write(key: _tokenKey, value: token);
  }
  
  static Future<String?> getToken() async {
    return await _storage.read(key: _tokenKey);
  }
  
  static Future<void> clearToken() async {
    await _storage.delete(key: _tokenKey);
  }
  
  static Future<bool> hasToken() async {
    final token = await getToken();
    return token != null && token.isNotEmpty;
  }
  
  // ============ User Data ============
  
  static Future<void> saveUser(UserModel user) async {
    final json = jsonEncode(user.toJson());
    await _storage.write(key: _userKey, value: json);
  }
  
  static Future<UserModel?> getUser() async {
    final json = await _storage.read(key: _userKey);
    if (json == null) return null;
    return UserModel.fromJson(jsonDecode(json));
  }
  
  // ============ Sales Representative Data ============
  
  static Future<void> saveSalesRep(SalesRepresentativeModel rep) async {
    final json = jsonEncode(rep.toJson());
    await _storage.write(key: _salesRepKey, value: json);
  }
  
  static Future<SalesRepresentativeModel?> getSalesRep() async {
    final json = await _storage.read(key: _salesRepKey);
    if (json == null) return null;
    return SalesRepresentativeModel.fromJson(jsonDecode(json));
  }
  
  // ============ Login State ============
  
  static Future<void> setLoggedIn(bool value) async {
    await _storage.write(key: _isLoggedInKey, value: value.toString());
  }
  
  static Future<bool> isLoggedIn() async {
    final value = await _storage.read(key: _isLoggedInKey);
    return value == 'true';
  }
  
  // ============ Save Full Session ============
  
  static Future<void> saveSession({
    required String token,
    required UserModel user,
    required SalesRepresentativeModel salesRep,
  }) async {
    await saveToken(token);
    await saveUser(user);
    await saveSalesRep(salesRep);
    await setLoggedIn(true);
  }
  
  static Future<void> saveLoginResponse(LoginResponse response) async {
    await saveSession(
      token: response.token,
      user: response.user,
      salesRep: response.salesRepresentative,
    );
  }
  
  // ============ Get Full Session ============
  
  static Future<AuthUserData?> getSession() async {
    final user = await getUser();
    final salesRep = await getSalesRep();
    
    if (user == null || salesRep == null) return null;
    
    return AuthUserData(user: user, salesRepresentative: salesRep);
  }
  
  // ============ Clear Session ============
  
  static Future<void> clearSession() async {
    await _storage.deleteAll();
  }
}
