export default class ProductModel {
    constructor(productModel = {}) {
        this.id = productModel.id || null;
        this.manufacturer_id = productModel.manufacturer_id || null;
        this.category_ids = productModel.category_ids || [];
        this.type = productModel.type || "";
        this.gender = productModel.gender || "";
        this.title = productModel.title || "";
        this.sub_title = productModel.sub_title || "";
        this.short_description = productModel.short_description || "";
        this.long_description = productModel.long_description || "";
        this.price = productModel.price || null;
        this.old_price = productModel.old_price || null;
        this.main_image = productModel.main_image || "";
        this.main_imageFile = productModel.main_imageFile || null;
        this.bulk_quantity = productModel.bulk_quantity || null;
        this.bulk_percent = productModel.bulk_percent || null;
        this.offerable = productModel.offerable || 0;
        this.watermarked = productModel.watermarked || 0;
        this.top_status = productModel.top_status || 0;
        this.hot_status = productModel.hot_status || 0;
        this.new_status = productModel.new_status || 0;
        this.status = productModel.status || 0;
        this.watermark = productModel.watermark || 0;
    }
}
