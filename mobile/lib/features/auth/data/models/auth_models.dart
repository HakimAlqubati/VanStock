/// User Model
/// نموذج المستخدم
class UserModel {
  final int id;
  final String name;
  final String email;

  UserModel({
    required this.id,
    required this.name,
    required this.email,
  });

  factory UserModel.fromJson(Map<String, dynamic> json) {
    return UserModel(
      id: json['id'] as int,
      name: json['name'] as String,
      email: json['email'] as String,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'email': email,
    };
  }
}

/// Sales Representative Model
/// نموذج مندوب المبيعات
class SalesRepresentativeModel {
  final int id;
  final String name;
  final String? repCode;
  final String? phone;
  final double cashWallet;
  final double creditLimitAllowance;
  final double commissionRate;
  final int? currentVehicleId;

  SalesRepresentativeModel({
    required this.id,
    required this.name,
    this.repCode,
    this.phone,
    required this.cashWallet,
    required this.creditLimitAllowance,
    required this.commissionRate,
    this.currentVehicleId,
  });

  factory SalesRepresentativeModel.fromJson(Map<String, dynamic> json) {
    return SalesRepresentativeModel(
      id: json['id'] as int,
      name: json['name'] as String,
      repCode: json['rep_code'] as String?,
      phone: json['phone'] as String?,
      cashWallet: double.tryParse(json['cash_wallet']?.toString() ?? '0') ?? 0,
      creditLimitAllowance: double.tryParse(json['credit_limit_allowance']?.toString() ?? '0') ?? 0,
      commissionRate: double.tryParse(json['commission_rate']?.toString() ?? '0') ?? 0,
      currentVehicleId: json['current_vehicle_id'] as int?,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'rep_code': repCode,
      'phone': phone,
      'cash_wallet': cashWallet,
      'credit_limit_allowance': creditLimitAllowance,
      'commission_rate': commissionRate,
      'current_vehicle_id': currentVehicleId,
    };
  }
}

/// Login Response Model
/// نموذج استجابة تسجيل الدخول
class LoginResponse {
  final bool success;
  final String message;
  final UserModel user;
  final SalesRepresentativeModel salesRepresentative;
  final String token;

  LoginResponse({
    required this.success,
    required this.message,
    required this.user,
    required this.salesRepresentative,
    required this.token,
  });

  factory LoginResponse.fromJson(Map<String, dynamic> json) {
    final data = json['data'] as Map<String, dynamic>;
    return LoginResponse(
      success: json['success'] as bool,
      message: json['message'] as String,
      user: UserModel.fromJson(data['user'] as Map<String, dynamic>),
      salesRepresentative: SalesRepresentativeModel.fromJson(
        data['sales_representative'] as Map<String, dynamic>,
      ),
      token: data['token'] as String,
    );
  }
}

/// Auth User Data (stored locally)
/// بيانات المستخدم المحفوظة محلياً
class AuthUserData {
  final UserModel user;
  final SalesRepresentativeModel salesRepresentative;

  AuthUserData({
    required this.user,
    required this.salesRepresentative,
  });
}
