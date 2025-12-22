import 'package:flutter/material.dart';
import 'package:vanstock_mobile/core/constants/app_colors.dart';
import 'package:vanstock_mobile/features/auth/data/models/auth_models.dart';
import 'package:vanstock_mobile/features/auth/data/repositories/auth_repository.dart';
import 'package:vanstock_mobile/features/auth/presentation/screens/login_screen.dart';

/// Home Screen - الشاشة الرئيسية
class HomeScreen extends StatefulWidget {
  final LoginResponse loginData;

  const HomeScreen({super.key, required this.loginData});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  int _currentIndex = 0;
  bool _isLoggingOut = false;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: _buildBody(),
      bottomNavigationBar: _buildBottomNav(),
    );
  }

  Widget _buildBody() {
    switch (_currentIndex) {
      case 0:
        return _buildDashboard();
      case 1:
        return _buildCustomersPlaceholder();
      case 2:
        return _buildOrdersPlaceholder();
      case 3:
        return _buildProfilePage();
      default:
        return _buildDashboard();
    }
  }

  Widget _buildDashboard() {
    final rep = widget.loginData.salesRepresentative;
    
    return CustomScrollView(
      slivers: [
        // App Bar
        SliverAppBar(
          expandedHeight: 200,
          pinned: true,
          flexibleSpace: FlexibleSpaceBar(
            background: Container(
              decoration: const BoxDecoration(
                gradient: AppColors.backgroundGradient,
              ),
              child: SafeArea(
                child: Padding(
                  padding: const EdgeInsets.all(20),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const SizedBox(height: 10),
                      Row(
                        children: [
                          CircleAvatar(
                            radius: 30,
                            backgroundColor: Colors.white,
                            child: Text(
                              rep.name.isNotEmpty ? rep.name[0].toUpperCase() : 'U',
                              style: const TextStyle(
                                fontSize: 24,
                                fontWeight: FontWeight.bold,
                                color: AppColors.primary,
                              ),
                            ),
                          ),
                          const SizedBox(width: 16),
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(
                                  'مرحباً، ${rep.name}',
                                  style: const TextStyle(
                                    color: Colors.white,
                                    fontSize: 20,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Text(
                                  rep.repCode ?? 'مندوب مبيعات',
                                  style: TextStyle(
                                    color: Colors.white.withValues(alpha: 0.8),
                                    fontSize: 14,
                                  ),
                                ),
                              ],
                            ),
                          ),
                          IconButton(
                            icon: const Icon(Icons.notifications_outlined, color: Colors.white),
                            onPressed: () {},
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ),
        ),

        // Stats Cards
        SliverToBoxAdapter(
          child: Padding(
            padding: const EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Welcome Card with Wallet
                _buildWalletCard(rep),
                
                const SizedBox(height: 20),
                
                // Quick Stats
                const Text(
                  'إحصائيات اليوم',
                  style: TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                const SizedBox(height: 12),
                
                Row(
                  children: [
                    Expanded(
                      child: _buildStatCard(
                        icon: Icons.receipt_long_rounded,
                        title: 'الفواتير',
                        value: '12',
                        color: AppColors.info,
                      ),
                    ),
                    const SizedBox(width: 12),
                    Expanded(
                      child: _buildStatCard(
                        icon: Icons.shopping_cart_rounded,
                        title: 'الطلبات',
                        value: '8',
                        color: AppColors.success,
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 12),
                Row(
                  children: [
                    Expanded(
                      child: _buildStatCard(
                        icon: Icons.payments_rounded,
                        title: 'التحصيلات',
                        value: '5,200',
                        color: AppColors.warning,
                        suffix: 'ر.ي',
                      ),
                    ),
                    const SizedBox(width: 12),
                    Expanded(
                      child: _buildStatCard(
                        icon: Icons.people_rounded,
                        title: 'العملاء',
                        value: '45',
                        color: AppColors.secondary,
                      ),
                    ),
                  ],
                ),
                
                const SizedBox(height: 24),
                
                // Quick Actions
                const Text(
                  'إجراءات سريعة',
                  style: TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                const SizedBox(height: 12),
                
                GridView.count(
                  shrinkWrap: true,
                  physics: const NeverScrollableScrollPhysics(),
                  crossAxisCount: 4,
                  mainAxisSpacing: 12,
                  crossAxisSpacing: 12,
                  children: [
                    _buildQuickAction(
                      icon: Icons.add_shopping_cart_rounded,
                      label: 'طلب جديد',
                      color: AppColors.primary,
                      onTap: () {},
                    ),
                    _buildQuickAction(
                      icon: Icons.receipt_rounded,
                      label: 'فاتورة',
                      color: AppColors.success,
                      onTap: () {},
                    ),
                    _buildQuickAction(
                      icon: Icons.payment_rounded,
                      label: 'تحصيل',
                      color: AppColors.warning,
                      onTap: () {},
                    ),
                    _buildQuickAction(
                      icon: Icons.assignment_return_rounded,
                      label: 'مرتجع',
                      color: AppColors.error,
                      onTap: () {},
                    ),
                    _buildQuickAction(
                      icon: Icons.person_add_rounded,
                      label: 'عميل جديد',
                      color: AppColors.info,
                      onTap: () {},
                    ),
                    _buildQuickAction(
                      icon: Icons.inventory_2_rounded,
                      label: 'المخزون',
                      color: AppColors.secondary,
                      onTap: () {},
                    ),
                    _buildQuickAction(
                      icon: Icons.map_rounded,
                      label: 'الخريطة',
                      color: AppColors.accent,
                      onTap: () {},
                    ),
                    _buildQuickAction(
                      icon: Icons.bar_chart_rounded,
                      label: 'التقارير',
                      color: AppColors.primaryLight,
                      onTap: () {},
                    ),
                  ],
                ),
                
                const SizedBox(height: 24),
                
                // Recent Activity
                const Text(
                  'آخر النشاطات',
                  style: TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                const SizedBox(height: 12),
                
                _buildActivityItem(
                  icon: Icons.receipt_long_rounded,
                  title: 'فاتورة #INV-2024-001',
                  subtitle: 'محلات الأمانة',
                  amount: '15,000 ر.ي',
                  time: 'منذ 30 دقيقة',
                  color: AppColors.success,
                ),
                _buildActivityItem(
                  icon: Icons.payments_rounded,
                  title: 'تحصيل #PAY-2024-015',
                  subtitle: 'سوبرماركت النور',
                  amount: '8,500 ر.ي',
                  time: 'منذ ساعة',
                  color: AppColors.info,
                ),
                _buildActivityItem(
                  icon: Icons.shopping_cart_rounded,
                  title: 'طلب جديد #ORD-2024-042',
                  subtitle: 'بقالة السلام',
                  amount: '3,200 ر.ي',
                  time: 'منذ ساعتين',
                  color: AppColors.warning,
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildWalletCard(SalesRepresentativeModel rep) {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        gradient: AppColors.primaryGradient,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: AppColors.primary.withValues(alpha: 0.3),
            blurRadius: 15,
            offset: const Offset(0, 8),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              const Text(
                'محفظة النقد',
                style: TextStyle(
                  color: Colors.white70,
                  fontSize: 14,
                ),
              ),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 4),
                decoration: BoxDecoration(
                  color: Colors.white.withValues(alpha: 0.2),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: const Row(
                  children: [
                    Icon(Icons.trending_up, color: Colors.white, size: 16),
                    SizedBox(width: 4),
                    Text(
                      '+12%',
                      style: TextStyle(color: Colors.white, fontSize: 12),
                    ),
                  ],
                ),
              ),
            ],
          ),
          const SizedBox(height: 8),
          Text(
            '${rep.cashWallet.toStringAsFixed(0)} ر.ي',
            style: const TextStyle(
              color: Colors.white,
              fontSize: 32,
              fontWeight: FontWeight.bold,
            ),
          ),
          const SizedBox(height: 16),
          Row(
            children: [
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    const Text(
                      'حد الائتمان المسموح',
                      style: TextStyle(color: Colors.white70, fontSize: 12),
                    ),
                    Text(
                      '${rep.creditLimitAllowance.toStringAsFixed(0)} ر.ي',
                      style: const TextStyle(
                        color: Colors.white,
                        fontSize: 16,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ],
                ),
              ),
              Container(
                width: 1,
                height: 40,
                color: Colors.white24,
              ),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.end,
                  children: [
                    const Text(
                      'نسبة العمولة',
                      style: TextStyle(color: Colors.white70, fontSize: 12),
                    ),
                    Text(
                      '${rep.commissionRate}%',
                      style: const TextStyle(
                        color: Colors.white,
                        fontSize: 16,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildStatCard({
    required IconData icon,
    required String title,
    required String value,
    required Color color,
    String? suffix,
  }) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.05),
            blurRadius: 10,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Container(
            padding: const EdgeInsets.all(8),
            decoration: BoxDecoration(
              color: color.withValues(alpha: 0.1),
              borderRadius: BorderRadius.circular(10),
            ),
            child: Icon(icon, color: color, size: 24),
          ),
          const SizedBox(height: 12),
          Text(
            title,
            style: TextStyle(
              color: AppColors.textSecondary,
              fontSize: 12,
            ),
          ),
          const SizedBox(height: 4),
          Row(
            crossAxisAlignment: CrossAxisAlignment.end,
            children: [
              Text(
                value,
                style: const TextStyle(
                  fontSize: 22,
                  fontWeight: FontWeight.bold,
                ),
              ),
              if (suffix != null) ...[
                const SizedBox(width: 4),
                Padding(
                  padding: const EdgeInsets.only(bottom: 2),
                  child: Text(
                    suffix,
                    style: TextStyle(
                      fontSize: 12,
                      color: AppColors.textSecondary,
                    ),
                  ),
                ),
              ],
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildQuickAction({
    required IconData icon,
    required String label,
    required Color color,
    required VoidCallback onTap,
  }) {
    return InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(12),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Container(
            padding: const EdgeInsets.all(12),
            decoration: BoxDecoration(
              color: color.withValues(alpha: 0.1),
              borderRadius: BorderRadius.circular(12),
            ),
            child: Icon(icon, color: color, size: 24),
          ),
          const SizedBox(height: 6),
          Text(
            label,
            style: const TextStyle(fontSize: 11),
            textAlign: TextAlign.center,
            maxLines: 1,
            overflow: TextOverflow.ellipsis,
          ),
        ],
      ),
    );
  }

  Widget _buildActivityItem({
    required IconData icon,
    required String title,
    required String subtitle,
    required String amount,
    required String time,
    required Color color,
  }) {
    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.03),
            blurRadius: 8,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: Row(
        children: [
          Container(
            padding: const EdgeInsets.all(10),
            decoration: BoxDecoration(
              color: color.withValues(alpha: 0.1),
              borderRadius: BorderRadius.circular(10),
            ),
            child: Icon(icon, color: color, size: 22),
          ),
          const SizedBox(width: 12),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  style: const TextStyle(
                    fontWeight: FontWeight.w600,
                    fontSize: 14,
                  ),
                ),
                Text(
                  subtitle,
                  style: TextStyle(
                    color: AppColors.textSecondary,
                    fontSize: 12,
                  ),
                ),
              ],
            ),
          ),
          Column(
            crossAxisAlignment: CrossAxisAlignment.end,
            children: [
              Text(
                amount,
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  color: color,
                  fontSize: 14,
                ),
              ),
              Text(
                time,
                style: TextStyle(
                  color: AppColors.textHint,
                  fontSize: 11,
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildCustomersPlaceholder() {
    return const Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(Icons.people_rounded, size: 64, color: AppColors.textSecondary),
          SizedBox(height: 16),
          Text('العملاء', style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold)),
          Text('قريباً...', style: TextStyle(color: AppColors.textSecondary)),
        ],
      ),
    );
  }

  Widget _buildOrdersPlaceholder() {
    return const Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(Icons.receipt_long_rounded, size: 64, color: AppColors.textSecondary),
          SizedBox(height: 16),
          Text('الطلبات', style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold)),
          Text('قريباً...', style: TextStyle(color: AppColors.textSecondary)),
        ],
      ),
    );
  }

  Widget _buildProfilePage() {
    final rep = widget.loginData.salesRepresentative;
    final user = widget.loginData.user;
    
    return SingleChildScrollView(
      padding: const EdgeInsets.all(20),
      child: Column(
        children: [
          const SizedBox(height: 40),
          
          // Profile Header
          CircleAvatar(
            radius: 50,
            backgroundColor: AppColors.primary,
            child: Text(
              rep.name.isNotEmpty ? rep.name[0].toUpperCase() : 'U',
              style: const TextStyle(
                fontSize: 40,
                fontWeight: FontWeight.bold,
                color: Colors.white,
              ),
            ),
          ),
          const SizedBox(height: 16),
          Text(
            rep.name,
            style: const TextStyle(
              fontSize: 24,
              fontWeight: FontWeight.bold,
            ),
          ),
          Text(
            rep.repCode ?? 'مندوب مبيعات',
            style: TextStyle(
              fontSize: 14,
              color: AppColors.textSecondary,
            ),
          ),
          
          const SizedBox(height: 32),
          
          // Info Cards
          _buildProfileInfoCard(
            icon: Icons.email_outlined,
            title: 'البريد الإلكتروني',
            value: user.email,
          ),
          _buildProfileInfoCard(
            icon: Icons.phone_outlined,
            title: 'رقم الهاتف',
            value: rep.phone ?? 'غير محدد',
          ),
          _buildProfileInfoCard(
            icon: Icons.account_balance_wallet_outlined,
            title: 'رصيد المحفظة',
            value: '${rep.cashWallet.toStringAsFixed(0)} ر.ي',
          ),
          _buildProfileInfoCard(
            icon: Icons.percent_outlined,
            title: 'نسبة العمولة',
            value: '${rep.commissionRate}%',
          ),
          
          const SizedBox(height: 32),
          
          // Logout Button
          SizedBox(
            width: double.infinity,
            child: ElevatedButton.icon(
              onPressed: _isLoggingOut ? null : _handleLogout,
              icon: _isLoggingOut 
                  ? const SizedBox(
                      width: 20,
                      height: 20,
                      child: CircularProgressIndicator(strokeWidth: 2, color: Colors.white),
                    )
                  : const Icon(Icons.logout_rounded),
              label: Text(_isLoggingOut ? 'جاري الخروج...' : 'تسجيل الخروج'),
              style: ElevatedButton.styleFrom(
                backgroundColor: AppColors.error,
                foregroundColor: Colors.white,
                padding: const EdgeInsets.symmetric(vertical: 16),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(12),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildProfileInfoCard({
    required IconData icon,
    required String title,
    required String value,
  }) {
    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.05),
            blurRadius: 8,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: Row(
        children: [
          Container(
            padding: const EdgeInsets.all(10),
            decoration: BoxDecoration(
              color: AppColors.primary.withValues(alpha: 0.1),
              borderRadius: BorderRadius.circular(10),
            ),
            child: Icon(icon, color: AppColors.primary, size: 22),
          ),
          const SizedBox(width: 16),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  style: TextStyle(
                    color: AppColors.textSecondary,
                    fontSize: 12,
                  ),
                ),
                Text(
                  value,
                  style: const TextStyle(
                    fontWeight: FontWeight.w600,
                    fontSize: 15,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Future<void> _handleLogout() async {
    setState(() => _isLoggingOut = true);
    
    try {
      await authRepository.logout();
      
      if (!mounted) return;
      
      Navigator.pushAndRemoveUntil(
        context,
        MaterialPageRoute(builder: (context) => const LoginScreen()),
        (route) => false,
      );
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
        setState(() => _isLoggingOut = false);
      }
    }
  }

  Widget _buildBottomNav() {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.08),
            blurRadius: 20,
            offset: const Offset(0, -5),
          ),
        ],
      ),
      child: SafeArea(
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 8),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceAround,
            children: [
              _buildNavItem(0, Icons.home_rounded, 'الرئيسية'),
              _buildNavItem(1, Icons.people_rounded, 'العملاء'),
              _buildNavItem(2, Icons.receipt_long_rounded, 'الطلبات'),
              _buildNavItem(3, Icons.person_rounded, 'حسابي'),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildNavItem(int index, IconData icon, String label) {
    final isSelected = _currentIndex == index;
    return InkWell(
      onTap: () => setState(() => _currentIndex = index),
      borderRadius: BorderRadius.circular(12),
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
        decoration: BoxDecoration(
          color: isSelected ? AppColors.primary.withValues(alpha: 0.1) : Colors.transparent,
          borderRadius: BorderRadius.circular(12),
        ),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Icon(
              icon,
              color: isSelected ? AppColors.primary : AppColors.textSecondary,
              size: 24,
            ),
            const SizedBox(height: 4),
            Text(
              label,
              style: TextStyle(
                color: isSelected ? AppColors.primary : AppColors.textSecondary,
                fontSize: 11,
                fontWeight: isSelected ? FontWeight.w600 : FontWeight.normal,
              ),
            ),
          ],
        ),
      ),
    );
  }
}
