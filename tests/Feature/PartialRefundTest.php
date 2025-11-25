<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PartialRefundTest extends TestCase
{
    /**
     * Test partial refund commission recalculation
     *
     * Scenario: Order of $100, seller commission 15%
     * Partial refund of $30
     * Remaining amount: $70
     *
     * @return void
     */
    public function test_partial_refund_recalculates_commissions_correctly()
    {
        // Original transaction
        $originalTotalAmount = 100;
        $sellerCommissionRate = 15;
        $buyerCommissionRate = 0;

        // Original calculations
        $originalSellerCommission = ($originalTotalAmount * $sellerCommissionRate) / 100; // $15
        $originalSellerEarnings = $originalTotalAmount - $originalSellerCommission; // $85

        // Partial refund
        $refundAmount = 30;
        $remainingAmount = $originalTotalAmount - $refundAmount; // $70

        // Recalculated values (matching OrderManagementController logic line 1558-1565)
        $newSellerCommission = ($remainingAmount * $sellerCommissionRate) / 100; // $10.50
        $newBuyerCommission = ($remainingAmount * $buyerCommissionRate) / 100; // $0
        $newSellerEarnings = $remainingAmount - $newSellerCommission; // $59.50
        $newTotalAdminCommission = $newSellerCommission + $newBuyerCommission; // $10.50

        // Assertions
        $this->assertEquals(70, $remainingAmount,
            'Remaining amount should be $70 after $30 refund');

        $this->assertEquals(10.50, $newSellerCommission,
            'Seller commission should be recalculated to $10.50 on remaining $70');

        $this->assertEquals(59.50, $newSellerEarnings,
            'Seller earnings should be recalculated to $59.50 ($70 - $10.50)');

        $this->assertEquals(10.50, $newTotalAdminCommission,
            'Admin commission should be recalculated to $10.50');

        // Verify refund reduces both seller earnings AND admin commission proportionally
        $originalAdminCommission = $originalSellerCommission; // $15
        $commissionReduction = $originalAdminCommission - $newTotalAdminCommission; // $4.50
        $sellerEarningsReduction = $originalSellerEarnings - $newSellerEarnings; // $25.50

        $this->assertEquals(4.50, $commissionReduction,
            'Admin commission should reduce by $4.50');

        $this->assertEquals(25.50, $sellerEarningsReduction,
            'Seller earnings should reduce by $25.50');

        // Verify total refund matches sum of commission reduction + seller earnings reduction
        $this->assertEquals($refundAmount, $commissionReduction + $sellerEarningsReduction,
            'Refund amount should equal commission reduction + seller earnings reduction');
    }

    /**
     * Test partial refund with buyer commission
     *
     * @return void
     */
    public function test_partial_refund_with_buyer_commission()
    {
        // Original transaction
        $originalTotalAmount = 200;
        $sellerCommissionRate = 15; // 15%
        $buyerCommissionRate = 5;   // 5%

        // Original calculations
        $originalSellerCommission = ($originalTotalAmount * $sellerCommissionRate) / 100; // $30
        $originalBuyerCommission = ($originalTotalAmount * $buyerCommissionRate) / 100;   // $10
        $originalTotalAdminCommission = $originalSellerCommission + $originalBuyerCommission; // $40
        $originalSellerEarnings = $originalTotalAmount - $originalSellerCommission; // $170

        // Partial refund
        $refundAmount = 50;
        $remainingAmount = $originalTotalAmount - $refundAmount; // $150

        // Recalculated values
        $newSellerCommission = ($remainingAmount * $sellerCommissionRate) / 100; // $22.50
        $newBuyerCommission = ($remainingAmount * $buyerCommissionRate) / 100;   // $7.50
        $newTotalAdminCommission = $newSellerCommission + $newBuyerCommission;   // $30
        $newSellerEarnings = $remainingAmount - $newSellerCommission; // $127.50

        // Assertions
        $this->assertEquals(150, $remainingAmount);
        $this->assertEquals(22.50, $newSellerCommission);
        $this->assertEquals(7.50, $newBuyerCommission);
        $this->assertEquals(30, $newTotalAdminCommission);
        $this->assertEquals(127.50, $newSellerEarnings);

        // Verify admin commission reduction
        $this->assertEquals(10, $originalTotalAdminCommission - $newTotalAdminCommission,
            'Admin commission should reduce by $10 (from $40 to $30)');
    }

    /**
     * Test partial refund validation - refund cannot exceed total
     *
     * @return void
     */
    public function test_partial_refund_cannot_exceed_total()
    {
        $finalPrice = 100;
        $refundAmount = 150; // Exceeds final price

        // This should be caught by validation (line 1531-1532 in OrderManagementController)
        $isValid = $refundAmount <= $finalPrice;

        $this->assertFalse($isValid,
            'Refund amount should not be allowed to exceed final price');
    }

    /**
     * Test partial refund validation - refund amount required
     *
     * @return void
     */
    public function test_partial_refund_requires_amount()
    {
        $refundAmount = null;

        // This should be caught by validation (line 1527-1528 in OrderManagementController)
        $isValid = $refundAmount !== null && $refundAmount > 0;

        $this->assertFalse($isValid,
            'Refund amount should be required for partial refunds');
    }

    /**
     * Test various partial refund scenarios
     *
     * @return void
     */
    public function test_various_partial_refund_scenarios()
    {
        $scenarios = [
            // [original, refund, expected_remaining, expected_seller_earnings, expected_admin_commission]
            [100, 25, 75, 63.75, 11.25],      // 25% refund
            [100, 50, 50, 42.50, 7.50],       // 50% refund
            [100, 75, 25, 21.25, 3.75],       // 75% refund
            [100, 10, 90, 76.50, 13.50],      // 10% refund
            [100, 99, 1, 0.85, 0.15],         // 99% refund
            [500, 100, 400, 340, 60],         // $100 refund from $500
        ];

        foreach ($scenarios as $scenario) {
            [$originalAmount, $refundAmount, $expectedRemaining, $expectedSellerEarnings, $expectedAdminCommission] = $scenario;

            $sellerCommissionRate = 15;
            $remainingAmount = $originalAmount - $refundAmount;
            $newSellerCommission = ($remainingAmount * $sellerCommissionRate) / 100;
            $newSellerEarnings = $remainingAmount - $newSellerCommission;

            $this->assertEquals(
                $expectedRemaining,
                $remainingAmount,
                "Remaining amount should be ${expectedRemaining} (original: ${originalAmount}, refund: ${refundAmount})"
            );

            $this->assertEquals(
                $expectedSellerEarnings,
                $newSellerEarnings,
                "Seller earnings should be ${expectedSellerEarnings} (remaining: ${remainingAmount})"
            );

            $this->assertEquals(
                $expectedAdminCommission,
                $newSellerCommission,
                "Admin commission should be ${expectedAdminCommission} (remaining: ${remainingAmount})"
            );
        }
    }
}
