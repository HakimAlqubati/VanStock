<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Customer Branches - فروع العملاء
        Schema::create('customer_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // اسم الفرع
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('district_id')->nullable()->constrained()->nullOnDelete();
            $table->text('address')->nullable();
            $table->string('contact_person')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_main')->default(false); // الفرع الرئيسي
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Customer Contact Info - معلومات التواصل للعملاء
        Schema::create('customer_contact_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('contact_type'); // phone, email, whatsapp, fax, etc.
            $table->string('contact_value');
            $table->string('label')->nullable(); // e.g., "Work", "Personal", "Sales Dept"
            $table->boolean('is_primary')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_contact_info');
        Schema::dropIfExists('customer_branches');
    }
};
