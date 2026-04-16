<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dateTime('loaned_at')->nullable()->after('loan_date');
            $table->dateTime('returned_at')->nullable()->after('return_date');
            $table->dateTime('due_at')->nullable()->after('due_date');
        });

        DB::table('loans')->orderBy('id')->get()->each(function ($loan) {
            $loanTime = $loan->created_at
                ? date('H:i:s', strtotime($loan->created_at))
                : '00:00:00';

            $returnTime = $loan->updated_at
                ? date('H:i:s', strtotime($loan->updated_at))
                : $loanTime;

            DB::table('loans')
                ->where('id', $loan->id)
                ->update([
                    'loaned_at' => $loan->loan_date ? $loan->loan_date . ' ' . $loanTime : null,
                    'returned_at' => $loan->return_date ? $loan->return_date . ' ' . $returnTime : null,
                    'due_at' => $loan->due_date ? $loan->due_date . ' ' . $loanTime : null,
                ]);
        });
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['loaned_at', 'returned_at', 'due_at']);
        });
    }
};
