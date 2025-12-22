import 'package:flutter/material.dart';
import 'package:vanstock_mobile/core/constants/app_colors.dart';
import 'package:vanstock_mobile/features/auth/data/repositories/auth_repository.dart';
import 'package:vanstock_mobile/shared/widgets/widgets.dart';

/// Login Screen
/// شاشة تسجيل الدخول
class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen>
    with SingleTickerProviderStateMixin {
  final _formKey = GlobalKey<FormState>();
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();
  final _emailFocusNode = FocusNode();
  final _passwordFocusNode = FocusNode();

  bool _isLoading = false;
  bool _rememberMe = false;

  late AnimationController _animationController;
  late Animation<double> _fadeAnimation;
  late Animation<Offset> _slideAnimation;

  @override
  void initState() {
    super.initState();
    _animationController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 1200),
    );

    _fadeAnimation = Tween<double>(begin: 0.0, end: 1.0).animate(
      CurvedAnimation(
        parent: _animationController,
        curve: const Interval(0.0, 0.5, curve: Curves.easeOut),
      ),
    );

    _slideAnimation = Tween<Offset>(
      begin: const Offset(0, 0.3),
      end: Offset.zero,
    ).animate(
      CurvedAnimation(
        parent: _animationController,
        curve: const Interval(0.3, 1.0, curve: Curves.easeOutCubic),
      ),
    );

    _animationController.forward();
  }

  @override
  void dispose() {
    _animationController.dispose();
    _emailController.dispose();
    _passwordController.dispose();
    _emailFocusNode.dispose();
    _passwordFocusNode.dispose();
    super.dispose();
  }

  Future<void> _handleLogin() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => _isLoading = true);

    try {
      final response = await authRepository.login(
        email: _emailController.text.trim(),
        password: _passwordController.text,
      );

      if (!mounted) return;

      // Show success message
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(response.message),
          backgroundColor: AppColors.success,
          behavior: SnackBarBehavior.floating,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
        ),
      );

      // TODO: Navigate to home screen
      // Navigator.pushReplacementNamed(context, '/home');
      
    } catch (e) {
      if (!mounted) return;
      
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(e.toString()),
          backgroundColor: AppColors.error,
          behavior: SnackBarBehavior.floating,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
        ),
      );
    } finally {
      if (mounted) {
        setState(() => _isLoading = false);
      }
    }
  }

  String? _validateEmail(String? value) {
    if (value == null || value.isEmpty) {
      return 'البريد الإلكتروني مطلوب';
    }
    if (!RegExp(r'^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$').hasMatch(value)) {
      return 'الرجاء إدخال بريد إلكتروني صحيح';
    }
    return null;
  }

  String? _validatePassword(String? value) {
    if (value == null || value.isEmpty) {
      return 'كلمة المرور مطلوبة';
    }
    if (value.length < 6) {
      return 'كلمة المرور يجب أن تكون 6 أحرف على الأقل';
    }
    return null;
  }

  @override
  Widget build(BuildContext context) {
    final size = MediaQuery.of(context).size;

    return Scaffold(
      body: Container(
        height: size.height,
        width: size.width,
        decoration: const BoxDecoration(
          gradient: AppColors.backgroundGradient,
        ),
        child: SafeArea(
          child: SingleChildScrollView(
            padding: const EdgeInsets.symmetric(horizontal: 24),
            child: Column(
              children: [
                SizedBox(height: size.height * 0.08),

                // Logo & Welcome Section
                FadeTransition(
                  opacity: _fadeAnimation,
                  child: _buildLogoSection(),
                ),

                SizedBox(height: size.height * 0.06),

                // Login Form Card
                SlideTransition(
                  position: _slideAnimation,
                  child: FadeTransition(
                    opacity: _fadeAnimation,
                    child: _buildLoginCard(),
                  ),
                ),

                const SizedBox(height: 24),

                // Support Section
                FadeTransition(
                  opacity: _fadeAnimation,
                  child: _buildSupportSection(),
                ),

                const SizedBox(height: 40),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildLogoSection() {
    return Column(
      children: [
        // App Logo
        Container(
          width: 100,
          height: 100,
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(24),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withOpacity(0.2),
                blurRadius: 20,
                offset: const Offset(0, 8),
              ),
            ],
          ),
          child: Center(
            child: Icon(
              Icons.local_shipping_rounded,
              size: 50,
              color: AppColors.primary,
            ),
          ),
        ),

        const SizedBox(height: 24),

        // App Name
        Text(
          'VanStock',
          style: Theme.of(context).textTheme.headlineLarge?.copyWith(
                color: Colors.white,
                fontWeight: FontWeight.bold,
                letterSpacing: 1,
              ),
        ),

        const SizedBox(height: 8),

        // Tagline
        Text(
          'تطبيق مندوب المبيعات',
          style: Theme.of(context).textTheme.bodyLarge?.copyWith(
                color: Colors.white.withOpacity(0.8),
              ),
        ),
      ],
    );
  }

  Widget _buildLoginCard() {
    return Container(
      padding: const EdgeInsets.all(28),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(24),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.1),
            blurRadius: 30,
            offset: const Offset(0, 10),
          ),
        ],
      ),
      child: Form(
        key: _formKey,
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Welcome Text
            Text(
              'مرحباً بك 👋',
              style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                    fontWeight: FontWeight.bold,
                  ),
            ),

            const SizedBox(height: 8),

            Text(
              'قم بتسجيل الدخول للمتابعة',
              style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                    color: AppColors.textSecondary,
                  ),
            ),

            const SizedBox(height: 32),

            // Email Field
            CustomTextField(
              controller: _emailController,
              hintText: 'أدخل البريد الإلكتروني',
              labelText: 'البريد الإلكتروني',
              prefixIcon: Icons.email_outlined,
              keyboardType: TextInputType.emailAddress,
              textInputAction: TextInputAction.next,
              focusNode: _emailFocusNode,
              onSubmitted: (_) => _passwordFocusNode.requestFocus(),
              validator: _validateEmail,
            ),

            const SizedBox(height: 20),

            // Password Field
            PasswordTextField(
              controller: _passwordController,
              hintText: 'أدخل كلمة المرور',
              labelText: 'كلمة المرور',
              focusNode: _passwordFocusNode,
              textInputAction: TextInputAction.done,
              onSubmitted: (_) => _handleLogin(),
              validator: _validatePassword,
            ),

            const SizedBox(height: 16),

            // Remember Me & Forgot Password
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                // Remember Me
                Row(
                  children: [
                    SizedBox(
                      width: 24,
                      height: 24,
                      child: Checkbox(
                        value: _rememberMe,
                        onChanged: (value) {
                          setState(() => _rememberMe = value ?? false);
                        },
                      ),
                    ),
                    const SizedBox(width: 8),
                    Text(
                      'تذكرني',
                      style: Theme.of(context).textTheme.bodyMedium,
                    ),
                  ],
                ),

                // Forgot Password
                TextButton(
                  onPressed: () {
                    // TODO: Navigate to forgot password
                  },
                  child: Text(
                    'نسيت كلمة المرور؟',
                    style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                          color: AppColors.secondary,
                          fontWeight: FontWeight.w600,
                        ),
                  ),
                ),
              ],
            ),

            const SizedBox(height: 28),

            // Login Button
            GradientButton(
              text: 'تسجيل الدخول',
              isLoading: _isLoading,
              onPressed: _handleLogin,
              icon: Icons.login_rounded,
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildSupportSection() {
    return Column(
      children: [
        // Divider with "OR"
        Row(
          children: [
            Expanded(
              child: Divider(
                color: Colors.white.withOpacity(0.3),
                thickness: 1,
              ),
            ),
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16),
              child: Text(
                'أو',
                style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                      color: Colors.white.withOpacity(0.7),
                    ),
              ),
            ),
            Expanded(
              child: Divider(
                color: Colors.white.withOpacity(0.3),
                thickness: 1,
              ),
            ),
          ],
        ),

        const SizedBox(height: 24),

        // Support Button
        OutlinedButton.icon(
          onPressed: () {
            // TODO: Open support
          },
          icon: Icon(
            Icons.headphones_outlined,
            color: Colors.white.withValues(alpha: 0.9),
            size: 20,
          ),
          label: Text(
            'الدعم الفني',
            style: Theme.of(context).textTheme.bodyLarge?.copyWith(
                  color: Colors.white.withOpacity(0.9),
                ),
          ),
          style: OutlinedButton.styleFrom(
            side: BorderSide(color: Colors.white.withOpacity(0.3)),
            padding: const EdgeInsets.symmetric(horizontal: 32, vertical: 14),
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(16),
            ),
          ),
        ),

        const SizedBox(height: 16),

        // Version
        Text(
          'الإصدار 1.0.0',
          style: Theme.of(context).textTheme.bodySmall?.copyWith(
                color: Colors.white.withOpacity(0.5),
              ),
        ),
      ],
    );
  }
}
