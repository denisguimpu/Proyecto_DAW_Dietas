<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Menu;

class MenuTest extends TestCase
{
    public function test_calculate_target_returns_empty_when_missing_data()
    {
        $menu = new Menu();
        $this->assertEmpty($menu->calculateTarget());
    }

    public function test_calculate_target_for_male_maintenance()
    {
        $menu = new Menu([
            'weight' => 80,
            'height' => 180,
            'age' => 30,
            'gender' => 'male',
            'activity_level' => 1.55,
            'goal' => 'maintenance',
        ]);

        // TMB = 10 * 80 + 6.25 * 180 - 5 * 30 + 5 = 800 + 1125 - 150 + 5 = 1780
        // Maintenance = 1780 * 1.55 = 2759
        // Protein = 80 * 2 = 160
        // Fats = 80 * 0.8 = 64
        // Carbs = (2759 - 160*4 - 64*9) / 4 = (2759 - 640 - 576) / 4 = 1543 / 4 = 385.75 -> 386

        $targets = $menu->calculateTarget();

        $this->assertEquals(2759, $targets['calories']);
        $this->assertEquals(160, $targets['protein']);
        $this->assertEquals(64, $targets['fats']);
        $this->assertEquals(386, $targets['carbs']);
    }

    public function test_calculate_target_for_female_deficit()
    {
        $menu = new Menu([
            'weight' => 60,
            'height' => 165,
            'age' => 25,
            'gender' => 'female',
            'activity_level' => 1.2, // sedentary
            'goal' => 'deficit',
        ]);

        // TMB = 10 * 60 + 6.25 * 165 - 5 * 25 - 161 = 600 + 1031.25 - 125 - 161 = 1345.25
        // Maintenance = 1345.25 * 1.2 = 1614.3
        // Target (Deficit) = 1614.3 - 500 = 1114.3 -> 1114
        // Protein = 60 * 2 = 120 (480 kcal)
        // Fats = 60 * 0.8 = 48 (432 kcal)
        // Carbs = (1114.3 - 480 - 432) / 4 = 202.3 / 4 = 50.575 -> 51

        $targets = $menu->calculateTarget();

        $this->assertEquals(1114, $targets['calories']);
        $this->assertEquals(120, $targets['protein']);
        $this->assertEquals(48, $targets['fats']);
        $this->assertEquals(51, $targets['carbs']);
    }

    public function test_calculate_target_for_male_volume()
    {
        $menu = new Menu([
            'weight' => 70,
            'height' => 175,
            'age' => 20,
            'gender' => 'male',
            'activity_level' => 1.725, // very active
            'goal' => 'volume',
        ]);

        // TMB = 10 * 70 + 6.25 * 175 - 5 * 20 + 5 = 700 + 1093.75 - 100 + 5 = 1698.75
        // Maintenance = 1698.75 * 1.725 = 2930.34
        // Target (Volume) = 2930.34 + 500 = 3430.34 -> 3430
        // Protein = 70 * 2 = 140
        // Fats = 70 * 0.8 = 56
        // Carbs = (3430.34 - 140*4 - 56*9) / 4 = (3430.34 - 560 - 504) / 4 = 2366.34 / 4 = 591.58 -> 592

        $targets = $menu->calculateTarget();

        $this->assertEquals(3430, $targets['calories']);
        $this->assertEquals(140, $targets['protein']);
        $this->assertEquals(56, $targets['fats']);
        $this->assertEquals(592, $targets['carbs']);
    }
}
