<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::rename('inventory', 'inventories');
    }

    public function down(): void
    {
        Schema::rename('inventories', 'inventory');
    }
};

//..