import 'package:flutter/material.dart';
import 'package:flutter_localizations/flutter_localizations.dart';
import 'package:vanstock_mobile/core/theme/app_theme.dart';
import 'package:vanstock_mobile/features/auth/presentation/screens/login_screen.dart';

/// VanStock App
/// التطبيق الرئيسي
class VanStockApp extends StatelessWidget {
  const VanStockApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'VanStock',
      debugShowCheckedModeBanner: false,
      
      // Theme
      theme: AppTheme.lightTheme,
      darkTheme: AppTheme.darkTheme,
      themeMode: ThemeMode.light,
      
      // RTL & Localization
      locale: const Locale('ar'),
      supportedLocales: const [
        Locale('ar'),
        Locale('en'),
      ],
      localizationsDelegates: const [
        GlobalMaterialLocalizations.delegate,
        GlobalWidgetsLocalizations.delegate,
        GlobalCupertinoLocalizations.delegate,
      ],
      
      // Home Screen
      home: const LoginScreen(),
    );
  }
}
