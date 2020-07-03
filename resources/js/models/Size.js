export default class Size {
    constructor(size = {}) {
        this.id = size.id || null;
        this.manufacturer_id = size.manufacturer_id || null;
        this.size_id = size.size_id || null;
        this.size = size.size || {};
        this.type = size.type || "";
        this.size = size.size || {};
        this.chest = size.chest || null;
        this.waist = size.waist || null;
        this.height = size.height || null;
        this.weight = size.weight || null;
        this.waist = size.waist || null;
        this.height = size.height || null;
        this.foot_length = size.foot_length || null;
    }
}