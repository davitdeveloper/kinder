export default class Article {
    constructor(article = {}) {
        this.id = article.id || null;
        this.article_category_id = article.article_category_id || null;
        this.title = article.title || "";
        this.alias = article.alias || "";
        this.description = article.description || "";
        this.main_image = article.main_image || "";
        this.main_imageFile = article.main_image_file || null;
        this.gallery = article.gallery || [];
        this.galleryFiles = article.galleryFiles || [];
        this.tags = article.tags || [];
    }
}
