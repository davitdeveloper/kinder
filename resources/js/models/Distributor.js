export default class Distributor {
    constructor(dist = {}) {
        this.id = dist.id || null;
        this.text = dist.text || "";
        this.price = dist.price || null;
        this.quantity = dist.quantity || null;
    }
}