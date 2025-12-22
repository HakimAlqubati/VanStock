import 'package:flutter/material.dart';

/// VanStock App Colors
/// ألوان تطبيق VanStock
class AppColors {
  AppColors._();

  // Primary Colors - الألوان الرئيسية
  static const Color primary = Color(0xFF1E3A5F);       // Deep Blue
  static const Color primaryLight = Color(0xFF2E5077);
  static const Color primaryDark = Color(0xFF0F2744);
  
  // Secondary Colors - الألوان الثانوية
  static const Color secondary = Color(0xFF00B4D8);     // Cyan
  static const Color secondaryLight = Color(0xFF48CAE4);
  static const Color secondaryDark = Color(0xFF0096C7);
  
  // Accent Colors - ألوان مميزة
  static const Color accent = Color(0xFFFF6B35);        // Orange
  static const Color accentLight = Color(0xFFFF8C5A);
  
  // Background Colors - ألوان الخلفية
  static const Color background = Color(0xFFF8FAFC);
  static const Color surface = Color(0xFFFFFFFF);
  static const Color surfaceVariant = Color(0xFFF1F5F9);
  
  // Dark Theme Colors
  static const Color backgroundDark = Color(0xFF0F172A);
  static const Color surfaceDark = Color(0xFF1E293B);
  static const Color surfaceVariantDark = Color(0xFF334155);
  
  // Text Colors - ألوان النص
  static const Color textPrimary = Color(0xFF1E293B);
  static const Color textSecondary = Color(0xFF64748B);
  static const Color textHint = Color(0xFF94A3B8);
  static const Color textOnPrimary = Color(0xFFFFFFFF);
  static const Color textOnSecondary = Color(0xFFFFFFFF);
  
  // Dark Theme Text
  static const Color textPrimaryDark = Color(0xFFF1F5F9);
  static const Color textSecondaryDark = Color(0xFF94A3B8);
  
  // Status Colors - ألوان الحالة
  static const Color success = Color(0xFF10B981);
  static const Color successLight = Color(0xFFD1FAE5);
  static const Color warning = Color(0xFFF59E0B);
  static const Color warningLight = Color(0xFFFEF3C7);
  static const Color error = Color(0xFFEF4444);
  static const Color errorLight = Color(0xFFFEE2E2);
  static const Color info = Color(0xFF3B82F6);
  static const Color infoLight = Color(0xFFDBEAFE);
  
  // Border & Divider Colors
  static const Color border = Color(0xFFE2E8F0);
  static const Color divider = Color(0xFFF1F5F9);
  static const Color borderDark = Color(0xFF334155);
  
  // Gradient Colors
  static const LinearGradient primaryGradient = LinearGradient(
    begin: Alignment.topLeft,
    end: Alignment.bottomRight,
    colors: [primary, Color(0xFF2E5077)],
  );
  
  static const LinearGradient secondaryGradient = LinearGradient(
    begin: Alignment.topLeft,
    end: Alignment.bottomRight,
    colors: [secondary, Color(0xFF0096C7)],
  );
  
  static const LinearGradient accentGradient = LinearGradient(
    begin: Alignment.topLeft,
    end: Alignment.bottomRight,
    colors: [accent, Color(0xFFFF8C5A)],
  );
  
  static const LinearGradient backgroundGradient = LinearGradient(
    begin: Alignment.topCenter,
    end: Alignment.bottomCenter,
    colors: [Color(0xFF1E3A5F), Color(0xFF0F2744)],
  );
}
