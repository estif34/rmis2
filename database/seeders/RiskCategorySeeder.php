<?php

namespace Database\Seeders;

use App\Models\RiskCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RiskCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Financial',
                'description' => 'Risks related to financial aspects of the business including market volatility, credit risks, liquidity issues, and financial reporting.'
            ],
            [
                'name' => 'Operational',
                'description' => 'Risks arising from inadequate or failed internal processes, people, and systems, or from external events.'
            ],
            [
                'name' => 'Strategic',
                'description' => "Risks associated with high-level goals, aligned with and supporting the organization's mission."
            ],
            [
                'name' => 'Compliance',
                'description' => 'Risks related to legal and regulatory compliance, including industry standards and internal policies.'
            ],
            [
                'name' => 'Reputational',
                'description' => "Risks that could damage the organization's reputation or brand."
            ],
            [
                'name' => 'Technology',
                'description' => 'Risks related to technology infrastructure, cybersecurity, data privacy, and digital transformation.'
            ],
        ];

        foreach ($categories as $category) {
            RiskCategory::create($category);
        }
    }
}