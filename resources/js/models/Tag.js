export default class Tag {
    constructor(tag = {}) {
        this.id = tag.id || null;
        this.name = tag.name || null;
    }
}
