export default class Color {
    constructor(color = {}) {
        this.id = color.id || null;
        this.name = color.name || "";
        this.value = color.value || "";
        this.tint = color.tint || "";
    }
}