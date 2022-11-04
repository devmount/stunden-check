<?php

namespace App\Exports;

use App\Models\Account;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use \DateTime;

class AccountsExport implements FromQuery, ShouldAutoSize, WithMapping, WithHeadings, WithColumnFormatting, WithStyles
{
	use Exportable;

	public function query()
	{
		return Account::query();
	}

	public function headings(): array
	{
		return [
			[
				__('Konto'),
				null,
				null,
				null,
				null,
				null,
				null,
				null,
				__('1. Person'),
				null,
				null,
				null,
				__('2. Person'),
				null,
				null,
				null,
			],
			[
				__('#'),
				__('Aktiv'),
				__('Getrennte Abrechnung'),
				__('Start Einstieg'),
				__('Pflichtstunden pro Zyklus'),
				__('Pflichtstunden Gesamt'),
				__('Geleistete Stunden'),
				__('Tage befreit'),
				__('Vorname'),
				__('Nachname'),
				__('E-Mail'),
				__('Admin'),
				__('Vorname'),
				__('Nachname'),
				__('E-Mail'),
				__('Admin'),
			]
		];
	}

	/**
	* @var Account $account
	*/
	public function map($account): array
	{
		return [
			$account->id,
			$account->active ? __('Ja') : __('Nein'),
			$account->separate_accounting ? __('Ja') : __('Nein'),
			Date::dateTimeToExcel(new DateTime(substr($account->start, 0, 10))),
			$account->target_hours,
			$account->total_hours,
			$account->sum_hours,
			$account->excemption_days,
			$account->users[0]->firstname,
			$account->users[0]->lastname,
			$account->users[0]->email,
			$account->users[0]->is_admin ? __('Ja') : __('Nein'),
			isset($account->users[1]) ? $account->users[1]->firstname : null,
			isset($account->users[1]) ? $account->users[1]->lastname : null,
			isset($account->users[1]) ? $account->users[1]->email : null,
			isset($account->users[1]) ? ($account->users[1]->is_admin ? __('Ja') : __('Nein')) : null,
		];
	}

	public function columnFormats(): array
	{
		return [
			'A' => NumberFormat::FORMAT_NUMBER,
			'B' => NumberFormat::FORMAT_TEXT,
			'C' => NumberFormat::FORMAT_TEXT,
			'D' => NumberFormat::FORMAT_DATE_YYYYMMDD,
			'E' => NumberFormat::FORMAT_NUMBER,
			'F' => NumberFormat::FORMAT_NUMBER_0,
			'F' => NumberFormat::FORMAT_NUMBER,
			'G' => NumberFormat::FORMAT_NUMBER,
			'H' => NumberFormat::FORMAT_TEXT,
			'I' => NumberFormat::FORMAT_TEXT,
			'J' => NumberFormat::FORMAT_TEXT,
			'K' => NumberFormat::FORMAT_TEXT,
			'L' => NumberFormat::FORMAT_TEXT,
			'M' => NumberFormat::FORMAT_TEXT,
			'N' => NumberFormat::FORMAT_TEXT,
			'O' => NumberFormat::FORMAT_TEXT,
		];
	}

	public function styles(Worksheet $sheet)
	{
		return [
			1 => ['font' => ['bold' => true]],
			2 => ['font' => ['bold' => true]],
		];
	}
}
