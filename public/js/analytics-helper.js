/**
 * DreamCrowd Google Analytics Helper
 * Provides easy-to-use methods for tracking custom events
 */

const DreamCrowdAnalytics = {
    /**
     * Check if gtag is available
     */
    isAvailable() {
        return typeof gtag !== 'undefined';
    },

    /**
     * Get payment currency (always USD as payments are processed in USD)
     */
    getPaymentCurrency() {
        return 'USD';
    },

    /**
     * Track service impression (when service card is visible)
     */
    trackServiceImpression(serviceData) {
        if (!this.isAvailable()) return;

        gtag('event', 'service_impression', {
            service_id: serviceData.id,
            service_title: serviceData.title,
            service_type: serviceData.type,
            service_delivery: serviceData.delivery,
            category: serviceData.category,
            category_id: serviceData.category_id,
            price: parseFloat(serviceData.price),
            seller_id: serviceData.seller_id
        });
    },

    /**
     * Track service click
     */
    trackServiceClick(serviceData, source = 'listing') {
        if (!this.isAvailable()) return;

        gtag('event', 'service_click', {
            service_id: serviceData.id,
            service_title: serviceData.title,
            click_source: source,
            category: serviceData.category,
            service_type: serviceData.type
        });
    },

    /**
     * Track view_item (service detail page)
     */
    trackViewItem(serviceData) {
        if (!this.isAvailable()) return;

        gtag('event', 'view_item', {
            currency: this.getPaymentCurrency(),
            value: parseFloat(serviceData.price),
            items: [{
                item_id: serviceData.id,
                item_name: serviceData.title,
                item_category: serviceData.category,
                price: parseFloat(serviceData.price),
                quantity: 1
            }]
        });
    },

    /**
     * Track view_item_list (service listing page)
     */
    trackViewItemList(listData, items) {
        if (!this.isAvailable()) return;

        gtag('event', 'view_item_list', {
            item_list_id: listData.list_id,
            item_list_name: listData.list_name,
            items: items.map(item => ({
                item_id: item.id,
                item_name: item.title,
                item_category: item.category,
                price: parseFloat(item.price),
                quantity: 1
            }))
        });
    },

    /**
     * Track begin_checkout (booking form shown)
     */
    trackBeginCheckout(serviceData) {
        if (!this.isAvailable()) return;

        gtag('event', 'begin_checkout', {
            currency: this.getPaymentCurrency(),
            value: parseFloat(serviceData.price),
            items: [{
                item_id: serviceData.id,
                item_name: serviceData.title,
                item_category: serviceData.category,
                price: parseFloat(serviceData.price),
                quantity: 1
            }]
        });
    },

    /**
     * Track purchase (payment successful)
     */
    trackPurchase(transactionData) {
        if (!this.isAvailable()) return;

        gtag('event', 'purchase', {
            transaction_id: transactionData.stripe_id,
            value: parseFloat(transactionData.total_amount),
            currency: this.getPaymentCurrency(),
            tax: 0,
            shipping: 0,
            coupon: transactionData.coupon_code || '',
            items: [{
                item_id: transactionData.service_id,
                item_name: transactionData.service_title,
                item_category: transactionData.category,
                price: parseFloat(transactionData.service_price),
                quantity: 1
            }],
            // Custom parameters
            service_type: transactionData.service_type,
            service_delivery: transactionData.delivery_type,
            order_frequency: transactionData.frequency,
            commission_amount: parseFloat(transactionData.admin_commission || 0),
            seller_earnings: parseFloat(transactionData.seller_earnings || 0),
            buyer_commission: parseFloat(transactionData.buyer_commission || 0)
        });
    },

    /**
     * Track order status change
     */
    trackOrderStatus(orderId, fromStatus, toStatus, orderValue) {
        if (!this.isAvailable()) return;

        gtag('event', 'order_status_change', {
            order_id: orderId,
            from_status: fromStatus,
            to_status: toStatus,
            order_value: parseFloat(orderValue)
        });
    },

    /**
     * Track search
     */
    trackSearch(searchTerm, filters = {}) {
        if (!this.isAvailable()) return;

        gtag('event', 'search', {
            search_term: searchTerm,
            ...filters
        });
    },

    /**
     * Track user signup
     */
    trackSignup(method = 'email') {
        if (!this.isAvailable()) return;

        gtag('event', 'sign_up', {
            method: method
        });
    },

    /**
     * Track user login
     */
    trackLogin(method = 'email') {
        if (!this.isAvailable()) return;

        gtag('event', 'login', {
            method: method
        });
    }
};

// Make globally available
window.DreamCrowdAnalytics = DreamCrowdAnalytics;

// Log initialization in debug mode
if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
    console.log('DreamCrowd Analytics Helper loaded');
}
