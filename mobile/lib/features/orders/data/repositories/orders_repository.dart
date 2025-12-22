import 'package:dio/dio.dart';
import 'package:vanstock_mobile/core/network/api_client.dart';
import 'package:vanstock_mobile/features/orders/data/models/order_models.dart';

/// Orders Repository
/// مستودع الطلبات
class OrdersRepository {
  final ApiClient _apiClient;

  OrdersRepository({ApiClient? apiClient}) : _apiClient = apiClient ?? ApiClient();

  /// الحصول على طلبات المندوب
  Future<List<SalesOrderModel>> getOrders({int page = 1, int perPage = 20}) async {
    try {
      final response = await _apiClient.get(
        '/sales-orders',
        queryParameters: {'page': page, 'per_page': perPage},
      );

      final data = response.data['data'] as List<dynamic>;
      return data.map((e) => SalesOrderModel.fromJson(e as Map<String, dynamic>)).toList();
    } on DioException catch (e) {
      throw _handleError(e);
    }
  }

  /// عرض تفاصيل طلب
  Future<SalesOrderModel> getOrderDetails(int orderId) async {
    try {
      final response = await _apiClient.get('/sales-orders/$orderId');
      return SalesOrderModel.fromJson(response.data['data'] as Map<String, dynamic>);
    } on DioException catch (e) {
      throw _handleError(e);
    }
  }

  /// إنشاء طلب جديد
  Future<SalesOrderModel> createOrder({
    required int customerId,
    required int storeId,
    required List<CartItem> items,
    DateTime? deliveryDate,
    String? notes,
  }) async {
    try {
      final response = await _apiClient.post('/sales-orders', data: {
        'customer_id': customerId,
        'store_id': storeId,
        'delivery_date': deliveryDate?.toIso8601String().split('T')[0],
        'notes': notes,
        'items': items.map((e) => e.toJson()).toList(),
      });

      return SalesOrderModel.fromJson(response.data['data'] as Map<String, dynamic>);
    } on DioException catch (e) {
      throw _handleError(e);
    }
  }

  /// البحث عن العملاء
  Future<List<CustomerModel>> searchCustomers({String? query}) async {
    try {
      final response = await _apiClient.get(
        '/sales-orders/data/customers',
        queryParameters: query != null ? {'q': query} : null,
      );

      final data = response.data['data'] as List<dynamic>;
      return data.map((e) => CustomerModel.fromJson(e as Map<String, dynamic>)).toList();
    } on DioException catch (e) {
      throw _handleError(e);
    }
  }

  /// البحث عن المنتجات
  Future<List<ProductModel>> searchProducts({String? query, int? categoryId}) async {
    try {
      final Map<String, dynamic> params = {};
      if (query != null) params['q'] = query;
      if (categoryId != null) params['category_id'] = categoryId;

      final response = await _apiClient.get(
        '/sales-orders/data/products',
        queryParameters: params.isNotEmpty ? params : null,
      );

      final data = response.data['data'] as List<dynamic>;
      return data.map((e) => ProductModel.fromJson(e as Map<String, dynamic>)).toList();
    } on DioException catch (e) {
      throw _handleError(e);
    }
  }

  String _handleError(DioException e) {
    if (e.response != null) {
      final data = e.response!.data;
      if (data is Map<String, dynamic> && data.containsKey('message')) {
        return data['message'].toString();
      }
    }
    return 'حدث خطأ غير متوقع';
  }
}

final ordersRepository = OrdersRepository();
