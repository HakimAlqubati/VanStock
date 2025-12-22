import 'package:dio/dio.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

/// API Client for VanStock Backend
/// عميل API للتواصل مع الخادم
class ApiClient {
  static const String baseUrl = 'http://10.0.2.2:7000/api'; // Android emulator
  // static const String baseUrl = 'http://localhost:7000/api'; // iOS simulator
  // static const String baseUrl = 'https://your-domain.com/api'; // Production
  
  late final Dio _dio;
  final FlutterSecureStorage _storage = const FlutterSecureStorage();
  
  static const String _tokenKey = 'auth_token';
  
  ApiClient() {
    _dio = Dio(BaseOptions(
      baseUrl: baseUrl,
      connectTimeout: const Duration(seconds: 30),
      receiveTimeout: const Duration(seconds: 30),
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
    ));
    
    _setupInterceptors();
  }
  
  void _setupInterceptors() {
    _dio.interceptors.add(InterceptorsWrapper(
      onRequest: (options, handler) async {
        // Add auth token if available
        final token = await getToken();
        if (token != null) {
          options.headers['Authorization'] = 'Bearer $token';
        }
        return handler.next(options);
      },
      onError: (error, handler) async {
        // Handle 401 Unauthorized
        if (error.response?.statusCode == 401) {
          await clearToken();
          // TODO: Navigate to login screen
        }
        return handler.next(error);
      },
    ));
  }
  
  // Token Management
  Future<void> saveToken(String token) async {
    await _storage.write(key: _tokenKey, value: token);
  }
  
  Future<String?> getToken() async {
    return await _storage.read(key: _tokenKey);
  }
  
  Future<void> clearToken() async {
    await _storage.delete(key: _tokenKey);
  }
  
  Future<bool> hasToken() async {
    final token = await getToken();
    return token != null && token.isNotEmpty;
  }
  
  // HTTP Methods
  Future<Response> get(String path, {Map<String, dynamic>? queryParameters}) {
    return _dio.get(path, queryParameters: queryParameters);
  }
  
  Future<Response> post(String path, {dynamic data}) {
    return _dio.post(path, data: data);
  }
  
  Future<Response> put(String path, {dynamic data}) {
    return _dio.put(path, data: data);
  }
  
  Future<Response> delete(String path, {dynamic data}) {
    return _dio.delete(path, data: data);
  }
  
  Future<Response> patch(String path, {dynamic data}) {
    return _dio.patch(path, data: data);
  }
}

// Singleton instance
final apiClient = ApiClient();
