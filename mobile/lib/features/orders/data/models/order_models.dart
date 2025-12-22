/// Sales Order Model
/// نموذج أمر البيع
class SalesOrderModel {
  final int id;
  final String orderNumber;
  final int customerId;
  final String? customerName;
  final String? customerPhone;
  final int storeId;
  final String? storeName;
  final DateTime orderDate;
  final DateTime? deliveryDate;
  final String status;
  final double subtotal;
  final double discountAmount;
  final double taxAmount;
  final double totalAmount;
  final String? notes;
  final List<SalesOrderItemModel> items;

  SalesOrderModel({
    required this.id,
    required this.orderNumber,
    required this.customerId,
    this.customerName,
    this.customerPhone,
    required this.storeId,
    this.storeName,
    required this.orderDate,
    this.deliveryDate,
    required this.status,
    required this.subtotal,
    required this.discountAmount,
    required this.taxAmount,
    required this.totalAmount,
    this.notes,
    this.items = const [],
  });

  factory SalesOrderModel.fromJson(Map<String, dynamic> json) {
    return SalesOrderModel(
      id: json['id'] as int,
      orderNumber: json['order_number'] as String,
      customerId: json['customer_id'] as int,
      customerName: json['customer']?['name'] as String?,
      customerPhone: json['customer']?['phone'] as String?,
      storeId: json['store_id'] as int,
      storeName: json['store']?['name'] as String?,
      orderDate: DateTime.parse(json['order_date'] as String),
      deliveryDate: json['delivery_date'] != null 
          ? DateTime.parse(json['delivery_date'] as String) 
          : null,
      status: json['status'] as String,
      subtotal: double.tryParse(json['subtotal']?.toString() ?? '0') ?? 0,
      discountAmount: double.tryParse(json['discount_amount']?.toString() ?? '0') ?? 0,
      taxAmount: double.tryParse(json['tax_amount']?.toString() ?? '0') ?? 0,
      totalAmount: double.tryParse(json['total_amount']?.toString() ?? '0') ?? 0,
      notes: json['notes'] as String?,
      items: (json['items'] as List<dynamic>?)
          ?.map((e) => SalesOrderItemModel.fromJson(e as Map<String, dynamic>))
          .toList() ?? [],
    );
  }

  String get statusArabic {
    switch (status) {
      case 'pending':
        return 'معلق';
      case 'confirmed':
        return 'مؤكد';
      case 'processing':
        return 'قيد التنفيذ';
      case 'shipped':
        return 'تم الشحن';
      case 'delivered':
        return 'تم التسليم';
      case 'cancelled':
        return 'ملغي';
      default:
        return status;
    }
  }
}

/// Sales Order Item Model
/// نموذج بند أمر البيع
class SalesOrderItemModel {
  final int id;
  final int productUnitId;
  final String? productName;
  final String? unitName;
  final double quantity;
  final double unitPrice;
  final double discount;
  final double total;

  SalesOrderItemModel({
    required this.id,
    required this.productUnitId,
    this.productName,
    this.unitName,
    required this.quantity,
    required this.unitPrice,
    required this.discount,
    required this.total,
  });

  factory SalesOrderItemModel.fromJson(Map<String, dynamic> json) {
    return SalesOrderItemModel(
      id: json['id'] as int,
      productUnitId: json['product_unit_id'] as int,
      productName: json['product_unit']?['product']?['name'] as String?,
      unitName: json['product_unit']?['unit']?['name'] as String?,
      quantity: double.tryParse(json['quantity']?.toString() ?? '0') ?? 0,
      unitPrice: double.tryParse(json['unit_price']?.toString() ?? '0') ?? 0,
      discount: double.tryParse(json['discount']?.toString() ?? '0') ?? 0,
      total: double.tryParse(json['total']?.toString() ?? '0') ?? 0,
    );
  }
}

/// Customer Model (Simple)
/// نموذج العميل (مختصر)
class CustomerModel {
  final int id;
  final String name;
  final String? phone;
  final String? address;
  final double creditLimit;
  final double balance;

  CustomerModel({
    required this.id,
    required this.name,
    this.phone,
    this.address,
    required this.creditLimit,
    required this.balance,
  });

  factory CustomerModel.fromJson(Map<String, dynamic> json) {
    return CustomerModel(
      id: json['id'] as int,
      name: json['name'] as String,
      phone: json['phone'] as String?,
      address: json['address'] as String?,
      creditLimit: double.tryParse(json['credit_limit']?.toString() ?? '0') ?? 0,
      balance: double.tryParse(json['balance']?.toString() ?? '0') ?? 0,
    );
  }
}

/// Product Model with Units
/// نموذج المنتج مع الوحدات
class ProductModel {
  final int id;
  final String name;
  final String? categoryName;
  final List<ProductUnitModel> units;

  ProductModel({
    required this.id,
    required this.name,
    this.categoryName,
    this.units = const [],
  });

  factory ProductModel.fromJson(Map<String, dynamic> json) {
    return ProductModel(
      id: json['id'] as int,
      name: json['name'] as String,
      categoryName: json['category']?['name'] as String?,
      units: (json['product_units'] as List<dynamic>?)
          ?.map((e) => ProductUnitModel.fromJson(e as Map<String, dynamic>))
          .toList() ?? [],
    );
  }
}

/// Product Unit Model
/// نموذج وحدة المنتج
class ProductUnitModel {
  final int id;
  final String unitName;
  final double sellingPrice;
  final double purchasePrice;

  ProductUnitModel({
    required this.id,
    required this.unitName,
    required this.sellingPrice,
    required this.purchasePrice,
  });

  factory ProductUnitModel.fromJson(Map<String, dynamic> json) {
    return ProductUnitModel(
      id: json['id'] as int,
      unitName: json['unit']?['name'] as String? ?? 'وحدة',
      sellingPrice: double.tryParse(json['selling_price']?.toString() ?? '0') ?? 0,
      purchasePrice: double.tryParse(json['purchase_price']?.toString() ?? '0') ?? 0,
    );
  }
}

/// Cart Item (for creating order)
/// عنصر السلة
class CartItem {
  final ProductModel product;
  final ProductUnitModel unit;
  double quantity;
  double unitPrice;
  double discount;

  CartItem({
    required this.product,
    required this.unit,
    this.quantity = 1,
    double? unitPrice,
    this.discount = 0,
  }) : unitPrice = unitPrice ?? unit.sellingPrice;

  double get total => (quantity * unitPrice) - discount;

  Map<String, dynamic> toJson() {
    return {
      'product_unit_id': unit.id,
      'quantity': quantity,
      'unit_price': unitPrice,
      'discount': discount,
    };
  }
}
