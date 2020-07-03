export default class ModelDiscount {
    constructor(discount = {}) {
        this.id = discount.id || null;
        this.model_id = discount.model_id || null;
        this.start = discount.start || "";
        this.end = discount.end || "";
        this.percent = discount.percent || "";
    }
}
