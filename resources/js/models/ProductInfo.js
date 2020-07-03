export default class ProductInfo {
    constructor(info = {}) {
        this.value = info.value || '';
        this.SCU = info.SCU || null;
        this.price = info.price || null;
        this.quantity = info.quantity || null;
        this.min_offer_count = info.min_offer_count || null;
    }
}