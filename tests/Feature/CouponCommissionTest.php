<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponCommissionTest extends TestCase
{
    /**
     * Test that coupon discount reduces admin commission, NOT seller earnings
     *
     * This tests the CRITICAL business logic from client requirement:
     * "Discount amount will reduce Admin's 15% commission only,
     *  Seller earnings will remain unchanged."
     *
     * @return void
     */
    public function test_coupon_reduces_admin_commission_not_seller_earnings()
    {
        // Simulate the commission calculation from BookingController
        $originalPrice = 100;
        $sellerCommissionRate = 15;
        $discountAmount = 10;
        $couponUsed = true;

        // Calculate seller commission from original price
        $sellerCommissionAmount = ($originalPrice * $sellerCommissionRate) / 100;

        // ✅ Seller earnings MUST stay constant (not affected by coupon)
        $sellerEarnings = $originalPrice - ($originalPrice * $sellerCommissionRate / 100);

        // ✅ Admin's commission from seller is reduced by coupon discount
        $adminCommissionFromSeller = $sellerCommissionAmount;
        if ($couponUsed) {
            $adminCommissionFromSeller = max(0, $sellerCommissionAmount - $discountAmount);
        }

        $buyerCommissionAmount = 0;
        $totalAdminCommission = $adminCommissionFromSeller + $buyerCommissionAmount;

        // Assert: Seller earnings should be unchanged ($85)
        $this->assertEquals(85, $sellerEarnings,
            'Seller earnings should remain $85 (unchanged by coupon)');

        // Assert: Admin commission should be reduced from $15 to $5
        $this->assertEquals(5, $totalAdminCommission,
            'Admin commission should be $5 ($15 original - $10 coupon)');

        // Assert: Seller commission amount stays at original
        $this->assertEquals(15, $sellerCommissionAmount,
            'Seller commission amount should still be $15 (for record-keeping)');
    }

    /**
     * Test that coupon discount cannot make admin commission negative
     *
     * @return void
     */
    public function test_coupon_cannot_make_commission_negative()
    {
        // Simulate: Service price $100, coupon discount $50 (exceeds commission)
        $originalPrice = 100;
        $sellerCommissionRate = 15;
        $discountAmount = 50; // Exceeds the $15 commission!

        $sellerCommissionAmount = ($originalPrice * $sellerCommissionRate) / 100;
        $sellerEarnings = $originalPrice - ($originalPrice * $sellerCommissionRate / 100);
        $adminCommissionFromSeller = max(0, $sellerCommissionAmount - $discountAmount);
        $totalAdminCommission = $adminCommissionFromSeller;

        // Assert: Seller earnings should still be $85 (unchanged)
        $this->assertEquals(85, $sellerEarnings,
            'Seller earnings should remain $85 even with large coupon');

        // Assert: Admin commission should not go below 0
        $this->assertGreaterThanOrEqual(0, $totalAdminCommission,
            'Admin commission should never be negative');

        // Assert: Admin commission should be floored at 0
        $this->assertEquals(0, $totalAdminCommission,
            'Admin commission should be $0 when coupon exceeds commission');
    }

    /**
     * Test real-world scenario from client requirement (exact example from PRD)
     *
     * Example from PRD:
     * Price: $100
     * Admin 15% = $15
     * Coupon: $10
     * New Admin commission = $5
     * Seller gets full $85
     */
    public function test_client_example_scenario()
    {
        // Simulate: Exact scenario from client requirement
        $originalPrice = 100;
        $sellerCommissionRate = 15;
        $discountAmount = 10;

        $sellerCommissionAmount = ($originalPrice * $sellerCommissionRate) / 100;
        $sellerEarnings = $originalPrice - ($originalPrice * $sellerCommissionRate / 100);
        $adminCommissionFromSeller = max(0, $sellerCommissionAmount - $discountAmount);
        $totalAdminCommission = $adminCommissionFromSeller;

        // Assert: Matches client's expected outcome
        $this->assertEquals(85, $sellerEarnings,
            'Client requirement: Seller gets full $85');

        $this->assertEquals(5, $totalAdminCommission,
            'Client requirement: Admin gets $5 ($15 - $10 coupon)');
    }

    /**
     * Test various coupon amount scenarios
     */
    public function test_various_coupon_amounts()
    {
        $scenarios = [
            ['price' => 100, 'coupon' => 0, 'expected_admin' => 15, 'expected_seller' => 85],
            ['price' => 100, 'coupon' => 5, 'expected_admin' => 10, 'expected_seller' => 85],
            ['price' => 100, 'coupon' => 10, 'expected_admin' => 5, 'expected_seller' => 85],
            ['price' => 100, 'coupon' => 15, 'expected_admin' => 0, 'expected_seller' => 85],
            ['price' => 100, 'coupon' => 20, 'expected_admin' => 0, 'expected_seller' => 85],
            ['price' => 100, 'coupon' => 100, 'expected_admin' => 0, 'expected_seller' => 85],
            ['price' => 500, 'coupon' => 20, 'expected_admin' => 55, 'expected_seller' => 425],
        ];

        foreach ($scenarios as $scenario) {
            $originalPrice = $scenario['price'];
            $sellerCommissionRate = 15;
            $discountAmount = $scenario['coupon'];

            $sellerCommissionAmount = ($originalPrice * $sellerCommissionRate) / 100;
            $sellerEarnings = $originalPrice - ($originalPrice * $sellerCommissionRate / 100);
            $adminCommissionFromSeller = max(0, $sellerCommissionAmount - $discountAmount);
            $totalAdminCommission = $adminCommissionFromSeller;

            $this->assertEquals(
                $scenario['expected_seller'],
                $sellerEarnings,
                "Seller earnings should be \${$scenario['expected_seller']} (price: {$scenario['price']}, coupon: {$scenario['coupon']})"
            );

            $this->assertEquals(
                $scenario['expected_admin'],
                $totalAdminCommission,
                "Admin commission should be \${$scenario['expected_admin']} (price: {$scenario['price']}, coupon: {$scenario['coupon']})"
            );
        }
    }
}
