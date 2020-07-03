export default class ProductDiscount {
    constructor(discount = {}) {
        this.id = discount.id || null;
        this.product_id = discount.product_id || null;
        this.start = discount.start || "";
        this.end = discount.end || "";
        this.percent = discount.percent || "";
    }
}
