import 'package:dio/dio.dart';
import 'package:vanstock_mobile/core/network/api_client.dart';
import 'package:vanstock_mobile/features/auth/data/models/auth_models.dart';

/// Auth Repository
/// مستودع المصادقة
class AuthRepository {
  final ApiClient _apiClient;

  AuthRepository({ApiClient? apiClient}) : _apiClient = apiClient ?? ApiClient();

  /// تسجيل الدخول
  Future<LoginResponse> login({
    required String email,
    required String password,
    String? deviceName,
  }) async {
    try {
      final response = await _apiClient.post('/auth/login', data: {
        'email': email,
        'password': password,
        'device_name': deviceName ?? 'mobile_app',
      });

      final loginResponse = LoginResponse.fromJson(response.data);
      
      // حفظ التوكن
      await _apiClient.saveToken(loginResponse.token);

      return loginResponse;
    } on DioException catch (e) {
      throw _handleError(e);
    }
  }

  /// الحصول على بيانات المستخدم الحالي
  Future<AuthUserData> getCurrentUser() async {
    try {
      final response = await _apiClient.get('/auth/me');
      final data = response.data['data'] as Map<String, dynamic>;
      
      return AuthUserData(
        user: UserModel.fromJson(data['user']),
        salesRepresentative: SalesRepresentativeModel.fromJson(data['sales_representative']),
      );
    } on DioException catch (e) {
      throw _handleError(e);
    }
  }

  /// تسجيل الخروج
  Future<void> logout() async {
    try {
      await _apiClient.post('/auth/logout');
      await _apiClient.clearToken();
    } on DioException catch (e) {
      // حذف التوكن حتى لو فشل الطلب
      await _apiClient.clearToken();
      throw _handleError(e);
    }
  }

  /// تسجيل الخروج من جميع الأجهزة
  Future<void> logoutAll() async {
    try {
      await _apiClient.post('/auth/logout-all');
      await _apiClient.clearToken();
    } on DioException catch (e) {
      await _apiClient.clearToken();
      throw _handleError(e);
    }
  }

  /// تحديث موقع المندوب
  Future<void> updateLocation({
    required double latitude,
    required double longitude,
  }) async {
    try {
      await _apiClient.post('/auth/update-location', data: {
        'latitude': latitude,
        'longitude': longitude,
      });
    } on DioException catch (e) {
      throw _handleError(e);
    }
  }

  /// التحقق من وجود توكن محفوظ
  Future<bool> isLoggedIn() async {
    return await _apiClient.hasToken();
  }

  /// معالجة الأخطاء
  String _handleError(DioException e) {
    if (e.response != null) {
      final data = e.response!.data;
      if (data is Map<String, dynamic>) {
        // Validation errors
        if (data.containsKey('errors')) {
          final errors = data['errors'] as Map<String, dynamic>;
          final firstError = errors.values.first;
          if (firstError is List && firstError.isNotEmpty) {
            return firstError.first.toString();
          }
        }
        // General message
        if (data.containsKey('message')) {
          return data['message'].toString();
        }
      }
      
      // HTTP status errors
      switch (e.response!.statusCode) {
        case 401:
          return 'بيانات الاعتماد غير صحيحة';
        case 403:
          return 'غير مصرح لك بالوصول';
        case 404:
          return 'المسار غير موجود';
        case 422:
          return 'البيانات المدخلة غير صحيحة';
        case 500:
          return 'خطأ في الخادم';
        default:
          return 'حدث خطأ غير متوقع';
      }
    }
    
    // Connection errors
    if (e.type == DioExceptionType.connectionTimeout ||
        e.type == DioExceptionType.receiveTimeout) {
      return 'انتهت مهلة الاتصال';
    }
    
    if (e.type == DioExceptionType.connectionError) {
      return 'تعذر الاتصال بالخادم';
    }
    
    return 'حدث خطأ غير متوقع';
  }
}

// Singleton instance
final authRepository = AuthRepository();
