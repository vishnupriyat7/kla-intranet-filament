<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing order_circulars sub_type values
        DB::table('order_circulars')->where('sub_type', 'Service')->update(['sub_type' => 1]);
        DB::table('order_circulars')->where('sub_type', 'Account')->update(['sub_type' => 2]);
        DB::table('order_circulars')->where('sub_type', 'Other')->update(['sub_type' => 3]);

        // Update sub_sub_type values
        DB::table('order_circulars')->where('sub_sub_type', 'CR')->update(['sub_sub_type' => 1]);
        DB::table('order_circulars')->where('sub_sub_type', 'TP')->update(['sub_sub_type' => 2]);
        DB::table('order_circulars')->where('sub_sub_type', 'G')->update(['sub_sub_type' => 3]);

        // Insert categories
        DB::table('categories')->insert([
            ['name' => 'Service Related', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Account Related', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Other', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insert sub_categories
        DB::table('sub_categories')->insert([
            ['code' => 'CR', 'name' => 'Transfer & Posting', 'category_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'CR', 'name' => 'Claim / Reimbersment', 'category_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'G', 'name' => 'General', 'category_id' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        // Optionally, you can reverse the inserts/updates if needed
        DB::table('order_circulars')->whereIn('sub_type', [1, 2, 3])->update(['sub_type' => null]);
        DB::table('order_circulars')->whereIn('sub_sub_type', [1, 2, 3])->update(['sub_sub_type' => null]);

        DB::table('sub_categories')
            ->whereIn('name', ['Transfer & Posting', 'Claim / Reimbersment', 'General'])
            ->delete();

        DB::table('categories')
            ->whereIn('name', ['Service Related', 'Account Related', 'Other'])
            ->delete();
    }
};
