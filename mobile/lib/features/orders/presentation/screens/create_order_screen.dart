import 'package:flutter/material.dart';
import 'package:vanstock_mobile/core/constants/app_colors.dart';
import 'package:vanstock_mobile/features/orders/data/models/order_models.dart';
import 'package:vanstock_mobile/features/orders/data/repositories/orders_repository.dart';

/// Create Order Screen
/// شاشة إنشاء طلب جديد
class CreateOrderScreen extends StatefulWidget {
  const CreateOrderScreen({super.key});

  @override
  State<CreateOrderScreen> createState() => _CreateOrderScreenState();
}

class _CreateOrderScreenState extends State<CreateOrderScreen> {
  // Form
  CustomerModel? _selectedCustomer;
  final List<CartItem> _cartItems = [];
  final _notesController = TextEditingController();
  DateTime? _deliveryDate;

  // Loading states
  bool _isSubmitting = false;
  bool _isLoadingCustomers = false;
  bool _isLoadingProducts = false;

  // Data
  List<CustomerModel> _customers = [];
  List<ProductModel> _products = [];

  @override
  void initState() {
    super.initState();
    _loadInitialData();
  }

  Future<void> _loadInitialData() async {
    setState(() {
      _isLoadingCustomers = true;
      _isLoadingProducts = true;
    });

    try {
      final customers = await ordersRepository.searchCustomers();
      final products = await ordersRepository.searchProducts();
      
      setState(() {
        _customers = customers;
        _products = products;
        _isLoadingCustomers = false;
        _isLoadingProducts = false;
      });
    } catch (e) {
      setState(() {
        _isLoadingCustomers = false;
        _isLoadingProducts = false;
      });
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('خطأ في تحميل البيانات: $e')),
        );
      }
    }
  }

  double get _subtotal => _cartItems.fold(0, (sum, item) => sum + (item.quantity * item.unitPrice));
  double get _totalDiscount => _cartItems.fold(0, (sum, item) => sum + item.discount);
  double get _total => _subtotal - _totalDiscount;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('طلب جديد'),
        actions: [
          if (_cartItems.isNotEmpty)
            TextButton.icon(
              onPressed: _submitOrder,
              icon: _isSubmitting
                  ? const SizedBox(
                      width: 16,
                      height: 16,
                      child: CircularProgressIndicator(strokeWidth: 2, color: Colors.white),
                    )
                  : const Icon(Icons.check, color: Colors.white),
              label: const Text('حفظ', style: TextStyle(color: Colors.white)),
            ),
        ],
      ),
      body: Column(
        children: [
          Expanded(
            child: SingleChildScrollView(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Customer Selection
                  _buildSectionTitle('العميل', Icons.person_outline),
                  _buildCustomerSelector(),
                  
                  const SizedBox(height: 24),
                  
                  // Products
                  _buildSectionTitle('المنتجات', Icons.shopping_cart_outlined),
                  _buildProductSelector(),
                  
                  const SizedBox(height: 16),
                  
                  // Cart Items
                  if (_cartItems.isNotEmpty) ...[
                    _buildCartItems(),
                    const SizedBox(height: 24),
                  ],
                  
                  // Delivery Date
                  _buildSectionTitle('تاريخ التسليم', Icons.calendar_today_outlined),
                  _buildDateSelector(),
                  
                  const SizedBox(height: 24),
                  
                  // Notes
                  _buildSectionTitle('ملاحظات', Icons.notes_outlined),
                  TextField(
                    controller: _notesController,
                    maxLines: 3,
                    decoration: const InputDecoration(
                      hintText: 'أضف ملاحظات للطلب (اختياري)',
                    ),
                  ),
                  
                  const SizedBox(height: 100), // Space for summary
                ],
              ),
            ),
          ),
          
          // Order Summary
          if (_cartItems.isNotEmpty) _buildOrderSummary(),
        ],
      ),
    );
  }

  Widget _buildSectionTitle(String title, IconData icon) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: Row(
        children: [
          Icon(icon, size: 20, color: AppColors.primary),
          const SizedBox(width: 8),
          Text(
            title,
            style: const TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.bold,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildCustomerSelector() {
    return InkWell(
      onTap: _showCustomerPicker,
      borderRadius: BorderRadius.circular(12),
      child: Container(
        padding: const EdgeInsets.all(16),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(
            color: _selectedCustomer != null ? AppColors.primary : AppColors.border,
          ),
        ),
        child: Row(
          children: [
            CircleAvatar(
              backgroundColor: AppColors.primary.withValues(alpha: 0.1),
              child: Icon(
                _selectedCustomer != null ? Icons.person : Icons.person_add,
                color: AppColors.primary,
              ),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    _selectedCustomer?.name ?? 'اختر العميل',
                    style: TextStyle(
                      fontWeight: _selectedCustomer != null ? FontWeight.w600 : FontWeight.normal,
                      color: _selectedCustomer != null ? AppColors.textPrimary : AppColors.textSecondary,
                    ),
                  ),
                  if (_selectedCustomer != null)
                    Text(
                      _selectedCustomer!.phone ?? 'بدون رقم',
                      style: const TextStyle(
                        fontSize: 12,
                        color: AppColors.textSecondary,
                      ),
                    ),
                ],
              ),
            ),
            const Icon(Icons.arrow_drop_down),
          ],
        ),
      ),
    );
  }

  Widget _buildProductSelector() {
    return InkWell(
      onTap: _showProductPicker,
      borderRadius: BorderRadius.circular(12),
      child: Container(
        padding: const EdgeInsets.all(16),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(color: AppColors.border),
        ),
        child: const Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(Icons.add_circle_outline, color: AppColors.primary),
            SizedBox(width: 8),
            Text(
              'إضافة منتج',
              style: TextStyle(
                color: AppColors.primary,
                fontWeight: FontWeight.w600,
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildCartItems() {
    return Column(
      children: _cartItems.asMap().entries.map((entry) {
        final index = entry.key;
        final item = entry.value;
        
        return Container(
          margin: const EdgeInsets.only(bottom: 12),
          padding: const EdgeInsets.all(12),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(12),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withValues(alpha: 0.05),
                blurRadius: 8,
              ),
            ],
          ),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                children: [
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          item.product.name,
                          style: const TextStyle(fontWeight: FontWeight.w600),
                        ),
                        Text(
                          item.unit.unitName,
                          style: const TextStyle(
                            fontSize: 12,
                            color: AppColors.textSecondary,
                          ),
                        ),
                      ],
                    ),
                  ),
                  IconButton(
                    icon: const Icon(Icons.delete_outline, color: AppColors.error),
                    onPressed: () => _removeItem(index),
                  ),
                ],
              ),
              const SizedBox(height: 12),
              Row(
                children: [
                  // Quantity
                  Expanded(
                    child: Row(
                      children: [
                        IconButton(
                          icon: const Icon(Icons.remove_circle_outline),
                          onPressed: () => _updateQuantity(index, item.quantity - 1),
                          color: AppColors.primary,
                          iconSize: 28,
                        ),
                        Text(
                          item.quantity.toStringAsFixed(item.quantity == item.quantity.toInt() ? 0 : 1),
                          style: const TextStyle(
                            fontSize: 18,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                        IconButton(
                          icon: const Icon(Icons.add_circle_outline),
                          onPressed: () => _updateQuantity(index, item.quantity + 1),
                          color: AppColors.primary,
                          iconSize: 28,
                        ),
                      ],
                    ),
                  ),
                  // Price
                  Text(
                    '${item.total.toStringAsFixed(0)} ر.ي',
                    style: const TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.bold,
                      color: AppColors.primary,
                    ),
                  ),
                ],
              ),
            ],
          ),
        );
      }).toList(),
    );
  }

  Widget _buildDateSelector() {
    return InkWell(
      onTap: _pickDate,
      borderRadius: BorderRadius.circular(12),
      child: Container(
        padding: const EdgeInsets.all(16),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(color: AppColors.border),
        ),
        child: Row(
          children: [
            const Icon(Icons.calendar_today, color: AppColors.primary),
            const SizedBox(width: 12),
            Text(
              _deliveryDate != null
                  ? '${_deliveryDate!.day}/${_deliveryDate!.month}/${_deliveryDate!.year}'
                  : 'اختر تاريخ التسليم (اختياري)',
              style: TextStyle(
                color: _deliveryDate != null ? AppColors.textPrimary : AppColors.textSecondary,
              ),
            ),
            const Spacer(),
            if (_deliveryDate != null)
              IconButton(
                icon: const Icon(Icons.close, size: 18),
                onPressed: () => setState(() => _deliveryDate = null),
              ),
          ],
        ),
      ),
    );
  }

  Widget _buildOrderSummary() {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.1),
            blurRadius: 20,
            offset: const Offset(0, -5),
          ),
        ],
      ),
      child: SafeArea(
        child: Column(
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                const Text('المجموع الفرعي'),
                Text('${_subtotal.toStringAsFixed(0)} ر.ي'),
              ],
            ),
            if (_totalDiscount > 0) ...[
              const SizedBox(height: 8),
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  const Text('الخصم', style: TextStyle(color: AppColors.error)),
                  Text('-${_totalDiscount.toStringAsFixed(0)} ر.ي', style: const TextStyle(color: AppColors.error)),
                ],
              ),
            ],
            const Divider(height: 20),
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                const Text('الإجمالي', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 18)),
                Text(
                  '${_total.toStringAsFixed(0)} ر.ي',
                  style: const TextStyle(
                    fontWeight: FontWeight.bold,
                    fontSize: 20,
                    color: AppColors.primary,
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }

  void _showCustomerPicker() {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(20)),
      ),
      builder: (context) => DraggableScrollableSheet(
        initialChildSize: 0.7,
        maxChildSize: 0.9,
        minChildSize: 0.5,
        expand: false,
        builder: (context, scrollController) => Column(
          children: [
            Container(
              padding: const EdgeInsets.all(16),
              child: Column(
                children: [
                  Container(
                    width: 40,
                    height: 4,
                    decoration: BoxDecoration(
                      color: Colors.grey[300],
                      borderRadius: BorderRadius.circular(2),
                    ),
                  ),
                  const SizedBox(height: 16),
                  const Text(
                    'اختر العميل',
                    style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                  ),
                ],
              ),
            ),
            Expanded(
              child: _isLoadingCustomers
                  ? const Center(child: CircularProgressIndicator())
                  : ListView.builder(
                      controller: scrollController,
                      itemCount: _customers.length,
                      itemBuilder: (context, index) {
                        final customer = _customers[index];
                        return ListTile(
                          leading: CircleAvatar(
                            backgroundColor: AppColors.primary.withValues(alpha: 0.1),
                            child: Text(
                              customer.name.isNotEmpty ? customer.name[0] : '?',
                              style: const TextStyle(color: AppColors.primary),
                            ),
                          ),
                          title: Text(customer.name),
                          subtitle: Text(customer.phone ?? 'بدون رقم'),
                          trailing: Text(
                            'رصيد: ${customer.balance.toStringAsFixed(0)}',
                            style: const TextStyle(fontSize: 12),
                          ),
                          onTap: () {
                            setState(() => _selectedCustomer = customer);
                            Navigator.pop(context);
                          },
                        );
                      },
                    ),
            ),
          ],
        ),
      ),
    );
  }

  void _showProductPicker() {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(20)),
      ),
      builder: (context) => DraggableScrollableSheet(
        initialChildSize: 0.7,
        maxChildSize: 0.9,
        minChildSize: 0.5,
        expand: false,
        builder: (context, scrollController) => Column(
          children: [
            Container(
              padding: const EdgeInsets.all(16),
              child: Column(
                children: [
                  Container(
                    width: 40,
                    height: 4,
                    decoration: BoxDecoration(
                      color: Colors.grey[300],
                      borderRadius: BorderRadius.circular(2),
                    ),
                  ),
                  const SizedBox(height: 16),
                  const Text(
                    'اختر المنتج',
                    style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                  ),
                ],
              ),
            ),
            Expanded(
              child: _isLoadingProducts
                  ? const Center(child: CircularProgressIndicator())
                  : ListView.builder(
                      controller: scrollController,
                      itemCount: _products.length,
                      itemBuilder: (context, index) {
                        final product = _products[index];
                        return ExpansionTile(
                          leading: const CircleAvatar(
                            backgroundColor: AppColors.secondary,
                            child: Icon(Icons.inventory_2, color: Colors.white, size: 20),
                          ),
                          title: Text(product.name),
                          subtitle: Text(product.categoryName ?? 'بدون فئة'),
                          children: product.units.map((unit) {
                            return ListTile(
                              contentPadding: const EdgeInsets.only(right: 72, left: 16),
                              title: Text(unit.unitName),
                              trailing: Text(
                                '${unit.sellingPrice.toStringAsFixed(0)} ر.ي',
                                style: const TextStyle(
                                  color: AppColors.primary,
                                  fontWeight: FontWeight.bold,
                                ),
                              ),
                              onTap: () {
                                _addToCart(product, unit);
                                Navigator.pop(context);
                              },
                            );
                          }).toList(),
                        );
                      },
                    ),
            ),
          ],
        ),
      ),
    );
  }

  void _addToCart(ProductModel product, ProductUnitModel unit) {
    setState(() {
      _cartItems.add(CartItem(product: product, unit: unit));
    });
  }

  void _removeItem(int index) {
    setState(() {
      _cartItems.removeAt(index);
    });
  }

  void _updateQuantity(int index, double newQty) {
    if (newQty <= 0) {
      _removeItem(index);
    } else {
      setState(() {
        _cartItems[index].quantity = newQty;
      });
    }
  }

  Future<void> _pickDate() async {
    final date = await showDatePicker(
      context: context,
      initialDate: _deliveryDate ?? DateTime.now(),
      firstDate: DateTime.now(),
      lastDate: DateTime.now().add(const Duration(days: 365)),
    );
    if (date != null) {
      setState(() => _deliveryDate = date);
    }
  }

  Future<void> _submitOrder() async {
    if (_selectedCustomer == null) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('الرجاء اختيار العميل')),
      );
      return;
    }

    if (_cartItems.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('الرجاء إضافة منتجات للطلب')),
      );
      return;
    }

    setState(() => _isSubmitting = true);

    try {
      await ordersRepository.createOrder(
        customerId: _selectedCustomer!.id,
        storeId: 1, // TODO: Get from user's assigned store
        items: _cartItems,
        deliveryDate: _deliveryDate,
        notes: _notesController.text.isEmpty ? null : _notesController.text,
      );

      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('تم إنشاء الطلب بنجاح'),
          backgroundColor: AppColors.success,
        ),
      );

      Navigator.pop(context, true);
    } catch (e) {
      if (!mounted) return;
      
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(e.toString()),
          backgroundColor: AppColors.error,
        ),
      );
    } finally {
      if (mounted) {
        setState(() => _isSubmitting = false);
      }
    }
  }

  @override
  void dispose() {
    _notesController.dispose();
    super.dispose();
  }
}
