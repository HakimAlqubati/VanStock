/// API Endpoints Configuration
/// إعدادات نقاط الاتصال بالـ API
class ApiEndpoints {
  ApiEndpoints._();

  // Base URL - عنوان الخادم الأساسي
  static const String baseUrl = 'http://localhost:7000/api';
  static const String prodBaseUrl = 'https://vanstock.example.com/api';
  
  // Auth Endpoints - نقاط المصادقة
  static const String login = '/auth/login';
  static const String logout = '/auth/logout';
  static const String refreshToken = '/auth/refresh';
  static const String me = '/auth/me';
  static const String forgotPassword = '/auth/forgot-password';
  static const String resetPassword = '/auth/reset-password';
  
  // Sales Representative Endpoints
  static const String profile = '/sales-representative/profile';
  static const String updateLocation = '/sales-representative/location';
  
  // Customers Endpoints - العملاء
  static const String customers = '/customers';
  static const String customerDetails = '/customers/{id}';
  
  // Products Endpoints - المنتجات
  static const String products = '/products';
  static const String productDetails = '/products/{id}';
  static const String categories = '/categories';
  
  // Orders Endpoints - الطلبات
  static const String salesOrders = '/sales-orders';
  static const String salesOrderDetails = '/sales-orders/{id}';
  
  // Invoices Endpoints - الفواتير
  static const String salesInvoices = '/sales-invoices';
  static const String salesInvoiceDetails = '/sales-invoices/{id}';
  
  // Payments Endpoints - المدفوعات
  static const String payments = '/payments';
  
  // Returns Endpoints - المرتجعات
  static const String salesReturns = '/sales-returns';
  
  // Reports Endpoints - التقارير
  static const String dailyReport = '/reports/daily';
  static const String salesReport = '/reports/sales';
}
