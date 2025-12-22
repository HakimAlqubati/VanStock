<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesRepresentative;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * تسجيل الدخول للمندوب
     * Login for sales representative
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'device_name' => 'nullable|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('بيانات الاعتماد غير صحيحة')],
            ]);
        }

        // التحقق من أن المستخدم هو مندوب مبيعات
        $salesRep = SalesRepresentative::where('user_id', $user->id)->first();

        if (!$salesRep) {
            throw ValidationException::withMessages([
                'email' => [__('هذا الحساب غير مرتبط بمندوب مبيعات')],
            ]);
        }

        // التحقق من أن المندوب نشط
        if (!$salesRep->is_active) {
            throw ValidationException::withMessages([
                'email' => [__('حساب المندوب غير نشط')],
            ]);
        }

        // إنشاء التوكن
        $deviceName = $request->device_name ?? 'mobile_app';
        $token = $user->createToken($deviceName)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => __('تم تسجيل الدخول بنجاح'),
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'sales_representative' => [
                    'id' => $salesRep->id,
                    'name' => $salesRep->name,
                    'rep_code' => $salesRep->rep_code,
                    'phone' => $salesRep->phone,
                    'cash_wallet' => $salesRep->cash_wallet,
                    'credit_limit_allowance' => $salesRep->credit_limit_allowance,
                    'commission_rate' => $salesRep->commission_rate,
                    'current_vehicle_id' => $salesRep->current_vehicle_id,
                ],
                'token' => $token,
            ],
        ]);
    }

    /**
     * الحصول على بيانات المستخدم الحالي
     * Get current user data
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        $salesRep = SalesRepresentative::where('user_id', $user->id)->first();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'sales_representative' => $salesRep ? [
                    'id' => $salesRep->id,
                    'name' => $salesRep->name,
                    'rep_code' => $salesRep->rep_code,
                    'phone' => $salesRep->phone,
                    'cash_wallet' => $salesRep->cash_wallet,
                    'credit_limit_allowance' => $salesRep->credit_limit_allowance,
                    'commission_rate' => $salesRep->commission_rate,
                    'current_vehicle_id' => $salesRep->current_vehicle_id,
                ] : null,
            ],
        ]);
    }

    /**
     * تسجيل الخروج
     * Logout
     */
    public function logout(Request $request): JsonResponse
    {
        // حذف التوكن الحالي فقط
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => __('تم تسجيل الخروج بنجاح'),
        ]);
    }

    /**
     * تسجيل الخروج من جميع الأجهزة
     * Logout from all devices
     */
    public function logoutAll(Request $request): JsonResponse
    {
        // حذف جميع التوكنات
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => __('تم تسجيل الخروج من جميع الأجهزة'),
        ]);
    }

    /**
     * تحديث موقع المندوب
     * Update sales representative location
     */
    public function updateLocation(Request $request): JsonResponse
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $user = $request->user();
        $salesRep = SalesRepresentative::where('user_id', $user->id)->first();

        if (!$salesRep) {
            return response()->json([
                'success' => false,
                'message' => __('المندوب غير موجود'),
            ], 404);
        }

        $salesRep->update([
            'last_latitude' => $request->latitude,
            'last_longitude' => $request->longitude,
            'last_location_update' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('تم تحديث الموقع بنجاح'),
        ]);
    }
}
