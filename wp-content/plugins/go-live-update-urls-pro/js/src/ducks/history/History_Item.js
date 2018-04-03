export default class Item {
	constructor(item) {
		this.old = item.old;
		this.new = item.new;
		this.date = item.date;
	}

	get_old_url() {
		return this.old;
	}

	get_new_url() {
		return this.new;
	}

	get_date() {
		return this.date;
	}
}
