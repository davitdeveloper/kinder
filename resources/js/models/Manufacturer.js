export default class Manufacturer {
    constructor(manufacturer = {}) {
        this.id = manufacturer.id || null;
        this.name = manufacturer.name || "";
        this.description = manufacturer.description || "";
        this.logo = manufacturer.logo || "";
        this.logoFile = manufacturer.logoFile || null;
    }
}