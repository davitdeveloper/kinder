export default class User {
    constructor(user = {}) {
        this.id = user.id || null;
        this.name = user.name || "";
        this.email = user.email || "";
        this.password = user.password || "";
        this.password_confirmation = user.password_confirmation || "";
        this.role_id = user.role || null;
        this.status = user.status || 0;
        this.distributor = user.distributor || {
            id: null,
            company: "",
            director: "",
            address: "",
            phone: "",
            tax_code: "",
            bank_name: "",
            iban: "",
            website: "",
            description: "",
            logo: "",
            logoFile: null,
        };
    }
}