<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Menghitung total pemasukan (income)
        $pemasukan = Transaction::whereHas('category', function ($query) {
            $query->where('is_expense', false); // Menggunakan is_expense = false untuk pemasukan
        })->sum('amount');

        // Menghitung total pengeluaran (expense)
        $pengeluaran = Transaction::whereHas('category', function ($query) {
            $query->where('is_expense', true); // Menggunakan is_expense = true untuk pengeluaran
        })->sum('amount');

        return [
            Stat::make('Pemasukan', 'Rp ' . number_format($pemasukan, 0, ',', '.')),
            Stat::make('Pengeluaran', 'Rp ' . number_format($pengeluaran, 0, ',', '.')),
        ];
    }
}
