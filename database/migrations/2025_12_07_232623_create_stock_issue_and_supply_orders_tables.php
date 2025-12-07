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
        // Stock Issue Orders - أوامر الصرف المخزني
        Schema::create('stock_issue_orders', function (Blueprint $table) {
            $table->id();
            $table->string('issue_number', 50)->unique();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->date('issue_date');
            $table->enum('status', ['pending', 'approved', 'issued', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->string('recipient_name')->nullable(); // اسم المستلم
            $table->string('recipient_department')->nullable(); // القسم المستلم
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Stock Issue Order Items - عناصر أوامر الصرف
        Schema::create('stock_issue_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_issue_order_id')->constrained('stock_issue_orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('unit_id')->constrained('units')->cascadeOnDelete();
            $table->decimal('quantity', 15, 4);
            $table->decimal('package_size', 15, 4)->default(1);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Stock Supply Orders - أوامر التوريد المخزني
        Schema::create('stock_supply_orders', function (Blueprint $table) {
            $table->id();
            $table->string('supply_number', 50)->unique();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->date('supply_date');
            $table->enum('status', ['pending', 'approved', 'received', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->string('supplier_name')->nullable(); // اسم المورد
            $table->string('supplier_reference')->nullable(); // مرجع المورد
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Stock Supply Order Items - عناصر أوامر التوريد
        Schema::create('stock_supply_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_supply_order_id')->constrained('stock_supply_orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('unit_id')->constrained('units')->cascadeOnDelete();
            $table->decimal('quantity', 15, 4);
            $table->decimal('package_size', 15, 4)->default(1);
            $table->decimal('unit_cost', 15, 4)->nullable(); // تكلفة الوحدة
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_supply_order_items');
        Schema::dropIfExists('stock_supply_orders');
        Schema::dropIfExists('stock_issue_order_items');
        Schema::dropIfExists('stock_issue_orders');
    }
};
