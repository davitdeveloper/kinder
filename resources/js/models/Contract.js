export default class Contract {
    constructor(contract = {}) {
        this.id = contract.id || null;
        this.user_id = contract.user_id || null;
        this.user = contract.user || { name: "" };
        this.name = contract.name || null;
        this.document = contract.document || "";
        this.date_start = contract.date_start || null;
        this.date_end = contract.date_end || null;
        this.status = contract.status || 0;
    }
}