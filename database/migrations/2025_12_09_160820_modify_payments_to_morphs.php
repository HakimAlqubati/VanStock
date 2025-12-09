<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop old foreign keys
            $table->dropForeign(['sales_invoice_id']);
            $table->dropForeign(['sales_representative_id']);

            // Drop old columns
            $table->dropColumn(['sales_invoice_id', 'sales_representative_id']);

            // Add morph columns for payable (can be SalesInvoice, SalesOrder, etc.)
            $table->nullableMorphs('payable');

            // Add morph columns for payer (can be SalesRepresentative, User, etc.)
            $table->nullableMorphs('payer');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop morph columns
            $table->dropMorphs('payable');
            $table->dropMorphs('payer');

            // Restore old columns
            $table->foreignId('sales_invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('sales_representative_id')->nullable()->constrained()->nullOnDelete();
        });
    }
};
