<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. جدول المركبات (الأصول المادية)
        // هذا الجدول هو الجذر للأصول المتحركة
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            
            // الربط بالمستودع المنطقي: كل شاحنة هي "وعاء" لمخزون
            // ملاحظة: يجب أن يتم إنشاء سجل في جدول stores من نوع 'van' أولاً
            $table->foreignId('store_id')
                  ->unique() // الشاحنة تملك مخزناً واحداً فقط، والمخزن لا يتبع لشاحنتين
                  ->constrained('stores')
                  ->restrictOnDelete(); // لا تحذف المخزن إذا كان مرتبطاً بسيارة

            // البيانات التعريفية للمركبة
            $table->string('plate_number')->unique(); // رقم اللوحة
            $table->string('model')->nullable(); // نوع السيارة (ايسوزو، تويوتا...)
            $table->string('chassis_number')->nullable();
            
            // الحالة التشغيلية
            $table->enum('status', ['active', 'maintenance', 'out_of_service'])->default('active');
            
            // بيانات الصيانة والقدرة
            $table->integer('max_load_capacity_kg')->nullable(); // الحمولة القصوى
            $table->date('license_expiry_date')->nullable(); // انتهاء الاستمارة
            $table->date('insurance_expiry_date')->nullable(); // انتهاء التأمين

            $table->timestamps();
            $table->softDeletes();
        });

        // 2. جدول مناديب المبيعات (الملف التشغيلي والمالي)
        Schema::create('sales_representatives', function (Blueprint $table) {
            $table->id();
            
            // الربط بالمستخدم (مصدر الصلاحيات والدخول)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // الربط بالمركبة الحالية (قابلة للتغيير)
            $table->foreignId('current_vehicle_id')
                  ->nullable() // المندوب قد لا يكون مستلماً لسيارة حالياً
                  ->constrained('vehicles')
                  ->nullOnDelete();

            // بيانات تعريفية للنظام
            $table->string('rep_code')->unique()->index(); // كود المندوب للفواتير (REP-101)
            
            // 💰 المحفظة المالية (Critical Financial Data)
            // العهدة النقدية: الكاش الذي في يد المندوب الآن
            $table->decimal('cash_wallet', 15, 2)->default(0); 
            // سقف المديونية: الحد الأقصى المسموح له ببيعه "آجل" للعملاء يومياً
            $table->decimal('credit_limit_allowance', 15, 2)->default(0);
            // نسبة العمولة
            $table->decimal('commission_rate', 5, 2)->default(0);

            // 📍 التتبع الجغرافي (Live Tracking)
            $table->decimal('last_latitude', 10, 8)->nullable()->index();
            $table->decimal('last_longitude', 11, 8)->nullable()->index();
            $table->timestamp('last_location_update')->nullable();

            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. جدول سجل تسليم السيارات (Audit Trail)
        // لتتبع تاريخ من قاد أي سيارة ومتى
        Schema::create('vehicle_assignments', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sales_representative_id')->constrained('sales_representatives')->cascadeOnDelete();
            
            // الفترة الزمنية
            $table->timestamp('assigned_at')->useCurrent(); // وقت الاستلام
            $table->timestamp('returned_at')->nullable(); // وقت التسليم (null = مازال معه)
            
            // قراءة العداد (لمراقبة الاستخدام الشخصي أو الصيانة)
            $table->decimal('start_odometer', 10, 2)->nullable();
            $table->decimal('end_odometer', 10, 2)->nullable();
            
            // حالة السيارة عند الاستلام/التسليم
            $table->text('notes')->nullable(); // ملاحظات (يوجد خدش في الباب الأيمن...)
            
            $table->timestamps();
            
            // فهرس لسرعة البحث في التاريخ
            $table->index(['vehicle_id', 'assigned_at']);
            $table->index(['sales_representative_id', 'assigned_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // الترتيب العكسي مهم جداً عند الحذف
        Schema::dropIfExists('vehicle_assignments');
        Schema::dropIfExists('sales_representatives');
        Schema::dropIfExists('vehicles');
    }
};