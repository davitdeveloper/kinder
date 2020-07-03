export default class ArticleCategory {
    constructor(articleCategory = {}) {
        this.id = articleCategory.id || null;
        this.name = articleCategory.name || "";
        this.alias = articleCategory.alias || "";
        this.description = articleCategory.description || "";
        this.image = articleCategory.image || "";
        this.imageFile = articleCategory.imageFile || null;
        this.status = articleCategory.status || 0;
    }
}
