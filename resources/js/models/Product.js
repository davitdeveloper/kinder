export default class Product {
    constructor(product = {}) {
        this.id = product.id || null;
        this.model_id = product.model_id || null;
        this.color_id = product.color_id || null;
        this.size_id = product.size_id || null;
        this.distributors = product.distributors || [];
        this.info = product.info || {};
        this.SCU = product.SCU || "";
        this.images = product.images || [];
        this.imageFiles = product.imageFiles || [];
    }
}